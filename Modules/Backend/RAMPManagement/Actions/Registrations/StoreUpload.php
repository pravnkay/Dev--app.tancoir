<?php

namespace Modules\Backend\RAMPManagement\Actions\Registrations;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\App\Profile\Entities\EnterpriseProfile;
use Modules\App\Profile\Entities\Participant;
use Modules\App\Profile\Entities\Profile;

use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Backend\RAMPManagement\Entities\Participation;
use Modules\Backend\RAMPManagement\Entities\Registration;

use Modules\Core\Auth\Entities\User;
use Modules\Core\Core\Enums\ParticipantCommunityEnum;
use Modules\Core\Core\Enums\ParticipantDesignationEnum;
use Modules\Core\Core\Enums\ParticipantGenderEnum;
use Modules\Core\Core\Enums\ParticipantReligionEnum;
use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\Core\Core\Enums\ProfileTypeEnum;

use RuntimeException;

use Spatie\SimpleExcel\SimpleExcelReader;

class StoreUpload
{
    use AsAction;

    private const COLUMN_USER_EMAIL 				= 'Email Address';

	private const COLUMN_USER_NAME 					= 'Email Address';
	private const COLUMN_PROFILE_NAME 				= 'நிறுவனத்தின் பெயர் / Company Name';

	private const COLUMN_ENTERPRISE_UDYAM 			= 'உதயம் எண் / UDYAM No. (Format: UDYAM-TN-00-0000000)';
	private const COLUMN_ENTERPRISE_NAME 			= 'நிறுவனத்தின் பெயர் / Company Name';
	private const COLUMN_ENTERPRISE_PLACE 			= 'ஊர் / Place';
	private const COLUMN_ENTERPRISE_DISTRICT 		= 'மாவட்டம் / District';

	private const COLUMN_CONTACT_PERSON 			= 'ஒப்புக்கொள்ளும் நபர் பெயர் / Name';
	private const COLUMN_CONTACT_EMAIL 				= 'Email Address';
	private const COLUMN_CONTACT_PHONE 				= 'CONTACT_PHONE_COLUMN_PLACEHOLDER';
	private const COLUMN_CONTACT_WHATSAPP 			= 'வாட்ஸ்அப் எண் / Whatsapp No.';

	private const COLUMN_PARTICIPANT_NAME 			= 'பங்கேற்பவரின் பெயர் / Participant Name';
	private const COLUMN_PARTICIPANT_AGE 			= 'வயது / Age';
	private const COLUMN_PARTICIPANT_DESIGNATION 	= 'பங்கேற்பவரின் நிறுவன பொறுப்பு / Designation';
	private const COLUMN_PARTICIPANT_GENDER 		= 'பாலினம் / Gender';
	private const COLUMN_PARTICIPANT_RELIGION 		= 'மதம் / Religion';
	private const COLUMN_PARTICIPANT_COMMUNITY 		= 'பிரிவு / Community';
	private const COLUMN_PARTICIPANT_WHATSAPP 		= 'வாட்ஸ்அப் எண் / Whatsapp No.';

	private const DEFAULT_PASSWORD 					= '9790862647';

    public function handle(ActionRequest $request, Event $filtered_event)
    {
        $file = $request->validated()['file'];

        try {

            [$number_of_rows_created, $feedback, $skipped_rows_list] = $this->import_spreadsheet($file, $filtered_event);

            $this->flash_feedback($number_of_rows_created, $feedback, $skipped_rows_list);

        } catch (\Throwable $exception) {

            notify('DB Error. Contact Admin!', ['status' => 'destructive', 'icon' => 'ban']);
            return redirect()->back();
        }

        return redirect()->route('backend.rampmanagement.registrations.upload', ['filtered_event' => $filtered_event->id]);
    }

    public function rules(): array
    {
        return ['file' => ['required', 'file', 'mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'max:4096']];
    }

    private function import_spreadsheet(UploadedFile $file, Event $event): array
    {
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
        $reader_type = in_array($extension, ['xlsx', 'csv'], true) ? $extension : 'xlsx';

        $rows = SimpleExcelReader::create($file->getRealPath(), $reader_type)->getRows();

        $number_of_rows_created = 0;
        $feedback = [];
        $skipped_rows_list = [];

        $rows->each(function (array $row, int $index) use ($event, &$number_of_rows_created, &$feedback, &$skipped_rows_list) {

            $processing_row_number = $index + 1;

            try {

                DB::transaction(fn () => $this->processRow($row, $event), 3);

                $number_of_rows_created++;

                $feedback[] = [
                    'row' => $processing_row_number,
                    'status' => 'success',
                    'message' => 'Registration processed successfully.',
                ];

            } catch (\Throwable $exception) {

                [$status, $message] = $this->classify_row_exception($exception);

                $skipped_rows_list[] = $processing_row_number;

                $feedback[] = [
                    'row' => $processing_row_number,
                    'status' => $status,
                    'message' => $message,
                ];
            }
        });

        return [$number_of_rows_created, $feedback, $skipped_rows_list];
    }

    private function flash_feedback(int $number_of_rows_created, array $rows, array $skipped_rows_list): void
    {
        $message = "{$number_of_rows_created} registrations processed.";
        $options = ['icon' => 'circle-check-big'];

        if (!empty($skipped_rows_list)) {
            $message .= ' Skipped rows: ' . implode(', ', $skipped_rows_list) . '. Check the detailed report below.';
            $options = ['status' => 'warning', 'icon' => 'alert-triangle'];
        } else {
            $options['status'] = 'success';
        }

        $summaryStatus = match (true) {
            !empty($skipped_rows_list) && $number_of_rows_created === 0 => 'error',
            !empty($skipped_rows_list) => 'warning',
            default => 'success',
        };

        session()->flash('upload_feedback', [
            'status' => $summaryStatus,
            'message' => $message,
            'rows' => $rows,
        ]);

        notify($message, $options);
    }

    private function classify_row_exception(\Throwable $exception): array
    {
        if ($exception instanceof RuntimeException) {

            $message = $this->format_skip_reason($exception->getMessage());

            if ($this->is_skip_exception($exception)) {
                return ['skipped', $message];
            }

            report($exception);
            return ['error', $message];
        }

        report($exception);
        return ['error', 'Unexpected error. Please check the application logs.'];
    }

    private function processRow(array $row, Event $event): void
    {
        $user = $this->resolve_user($row);
        [$profile, $participant] = $this->resolve_existing_profile_and_participant($row, $user);

        if (!$profile) {
            $profile = $this->create_profile($row, $user);
            $this->create_enterprise_profile($row, $profile);
        }

        if (!$participant) {
            $participant = $this->create_participant($row, $user, $profile);
        }

        $this->create_registration_record($event, $user, $profile, $participant);
    }

    private function resolve_user(array $row): User
    {
        $email = $this->value_from_row($row, self::COLUMN_USER_EMAIL);

        if (!$email) {
            throw new RuntimeException('Skipped:missing_email');
        }

        $name = Str::of(Str::before($email, '@'))->replaceMatches('/[^a-z]+/i', ' ')->squish()->title()->toString();
        $name = $name === '' ? 'User' : $name;

        $user = User::firstOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make(self::DEFAULT_PASSWORD)]
        );

        if ($user->name !== $name) {
            $user->fill(['name' => $name])->save();
        }

        return $user;
    }

	private function resolve_existing_profile_and_participant(array $row, User $user): array
	{
		$udyam = $this->value_from_row($row, self::COLUMN_ENTERPRISE_UDYAM);

		if ($udyam === null) {
			return [null, null];
		}

		$normalized_udyam = Str::of($udyam)->lower()->toString();

		$enterprise_profile = EnterpriseProfile::with('profile')
			->whereNotNull('udyam')
			->whereRaw('LOWER(udyam) = ?', [$normalized_udyam])
			->first();

		if (!$enterprise_profile) {
			return [null, null];
		}

		$profile = $enterprise_profile->profile;

		if (!$profile) {
			throw new RuntimeException('Skipped:udyam_profile_missing');
		}

		if ((int) $profile->user_id !== (int) $user->id) {
			throw new RuntimeException('Skipped:udyam_exists');
		}

		$whatsapp = $this->value_from_row($row, self::COLUMN_PARTICIPANT_WHATSAPP);

		$participant = null;

		if ($whatsapp !== null) {
			$participant = Participant::where('profile_id', $profile->id)
				->where('whatsapp', $whatsapp)
				->first();
		}

		return [$profile, $participant];
	}

    private function create_profile(array $row, User $user): Profile
    {
        return Profile::create([
            'user_id' 				=> $user->id,
            'name' 					=> $this->value_from_row($row, self::COLUMN_PROFILE_NAME),
            'type' 					=> ProfileTypeEnum::ENTERPRISE->value,
            'status' 				=> ProfileStatusEnum::APPROVED->value,
            'is_active' 			=> false,
            'is_allowed_for_ramp' 	=> true,
            'submitted_at' 			=> now(),
            'reviewed_at' 			=> now(),
            'review_remarks' 		=> 'Auto created & Approved',
        ]);
    }

    private function create_enterprise_profile(array $row, Profile $profile): void
    {
        EnterpriseProfile::create([
            'profile_id' => $profile->id,
            'udyam' => $this->value_from_row($row, self::COLUMN_ENTERPRISE_UDYAM),
            'enterprise_name' => Str::of($this->value_from_row($row, self::COLUMN_ENTERPRISE_NAME))
                ->replace('.', ' ')
                ->upper()
                ->squish()
                ->toString(),
            'enterprise_place' => Str::of($this->value_from_row($row, self::COLUMN_ENTERPRISE_PLACE))
                ->replace('.', ' ')
                ->squish()
                ->title()
                ->toString(),
            'enterprise_district' => Str::of($this->value_from_row($row, self::COLUMN_ENTERPRISE_DISTRICT))
                ->before('/')
                ->lower()
                ->replaceMatches('/[^a-z]+/u', ' ')
                ->squish()
                ->replace(' ', '_')
                ->toString(),
            'contact_person_name' => Str::of($this->value_from_row($row, self::COLUMN_CONTACT_PERSON))
                ->replace('.', ' ')
                ->squish()
                ->title()
                ->toString(),
            'contact_email' => $this->value_from_row($row, self::COLUMN_CONTACT_EMAIL),
        ]);
    }

    private function create_participant(array $row, User $user, Profile $profile): Participant
    {
        $designation = $this->enum_value_from_row($row, self::COLUMN_PARTICIPANT_DESIGNATION, ParticipantDesignationEnum::class);
        $gender = $this->enum_value_from_row($row, self::COLUMN_PARTICIPANT_GENDER, ParticipantGenderEnum::class);
        $religion = $this->enum_value_from_row($row, self::COLUMN_PARTICIPANT_RELIGION, ParticipantReligionEnum::class);
        $community = $this->enum_value_from_row($row, self::COLUMN_PARTICIPANT_COMMUNITY, ParticipantCommunityEnum::class);

        return Participant::create([
            'user_id' 		=> $user->id,
            'profile_id' 	=> $profile->id,
            'name' 			=> Str::of($this->value_from_row($row, self::COLUMN_PARTICIPANT_NAME))->replace('.', ' ')->squish()->title()->toString(),
            'age' 			=> $this->value_from_row($row, self::COLUMN_PARTICIPANT_AGE),
            'designation' 	=> $designation?->value,
            'gender' 		=> $gender?->value,
            'religion' 		=> $religion?->value,
            'community' 	=> $community?->value,
            'whatsapp' 		=> $this->value_from_row($row, self::COLUMN_PARTICIPANT_WHATSAPP),
        ]);
    }

    private function create_registration_record(Event $event, User $user, Profile $profile, Participant $participant): void
    {
        $counts = DB::table('ramp_registrations')
            ->where('event_id', $event->id)
            ->lockForUpdate()
            ->selectRaw('COUNT(*) AS total_count, SUM(CASE WHEN is_approved_to_participate = 1 THEN 1 ELSE 0 END) AS approved_count')
            ->first();

        $total_registrations = (int) ($counts->total_count ?? 0);
        $approved_registrations = (int) ($counts->approved_count ?? 0);
        $participant_limit = (int) ($event->participant_count ?? 0);

        $is_approved = $participant_limit > 0 && $approved_registrations < $participant_limit;

        $registration = Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'profile_id' => $profile->id,
            'participant_id' => $participant->id,
            'registration_serial' => $total_registrations + 1,
            'is_approved_to_participate' => $is_approved,
        ]);

        $this->create_participation_record($registration);
    }

    private function create_participation_record(Registration $registration): void
    {
        Participation::firstOrCreate([
            'registration_id' => $registration->id,
        ]);
    }

    private function value_from_row(array $row, string $column): ?string
    {
        if (!array_key_exists($column, $row)) {
            return null;
        }

        $value = $row[$column];

        if (is_string($value)) {
            $value = trim($value);
        }

        return $value === '' ? null : $value;
    }

    private function enum_value_from_row(array $row, string $column, string $enumClass): ?\BackedEnum
    {
        $raw = $this->value_from_row($row, $column);

        if ($raw === null) {
            return null;
        }

        foreach ($enumClass::cases() as $case) {

            $labelForUploader = method_exists($case, 'label_for_uploader') ? $case->label_for_uploader() : null;
            $label = method_exists($case, 'label') ? $case->label() : $case->name;

            if ($this->matches_enum_label($raw, $labelForUploader) || $this->matches_enum_label($raw, $label)) {
                return $case;
            }
			
        }

        throw new RuntimeException("Skipped: Invalid {$column} value '{$raw}' for Enums");
    }

    private function matches_enum_label(string $input, ?string $label): bool
    {
        if ($label === null) {
            return false;
        }

        return Str::of($input)->trim()->lower()->toString() === Str::of($label)->trim()->lower()->toString();
    }

    private function format_skip_reason(string $message): string
    {
        if (!str_starts_with($message, 'Skipped:')) {
            return $message;
        }

        $reason = trim(substr($message, strlen('Skipped:')));

        return match ($reason) {
            'missing_email' 		=> 'Missing email address.',
            'udyam_exists' 			=> 'UDYAM already exists under a different user.',
            'udyam_profile_missing' => 'UDYAM exists but the linked profile record is missing.',
            default 				=> $reason,
        };
    }

    private function is_skip_exception(RuntimeException $exception): bool
    {
        return str_starts_with($exception->getMessage(), 'Skipped:');
    }
}
