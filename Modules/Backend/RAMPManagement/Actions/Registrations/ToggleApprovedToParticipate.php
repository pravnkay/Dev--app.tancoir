<?php

namespace Modules\Backend\RAMPManagement\Actions\Registrations;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Registration;

class ToggleApprovedToParticipate
{
	use AsAction;

	public function handle(Registration $registration)
    {
		if(!$registration->is_eligible_to_participate) {
			notify('Not eligible!', ['status'=> 'destructive', 'icon' => 'circle-x']);
			return redirect()->back();
		}

		$registration->loadMissing('enterprise', 'event.programme');

		# Find if approving or dis-approving
		$toggle_to_true = !$registration->is_approved_to_participate;

		# If approving
		if ($toggle_to_true) {

			# If already full capacity of the event is approved
			if (self::capacity_full($registration)) {
				# Notify limit reached and do nothing. End.
				notify('Participant limit reached for this event.', ['status' => 'destructive', 'icon' => 'ban']);
				return redirect()->back();
			}

			# Find the programme of the event of the registration			
			$programme_id = $registration->event->programme->id;

			# Check if the registration's enterprise already participated in any event of this programe
			$enterprise_already_participated_in_this_programme = $registration->enterprise->registrations()
			->where('is_approved_to_participate', true)
			->whereHas('event', fn ($q) => $q
				->where('programme_id', $programme_id)
				->where('id', '!=', $registration->event_id))
			->exists();

			# If already participated
			if ($enterprise_already_participated_in_this_programme) {
				# Notify already participated and do nothing. End.
				notify('Already participated in this programme', ['status'=> 'destructive', 'icon' => 'ban']);
				return redirect()->back();
			# Else, not already participated
			} else {
				# Update registration's approval to participate to approved.
				$registration->update([
					'is_approved_to_participate' => $toggle_to_true
				]);

				notify('Registration is now participating!', ['icon' => 'circle-check-big']);

				# After registration is approved, create a participation, if one already not exists (By any off-chance)
				self::ensure_participation_exists($registration);

				# Alter all other registrations of this enterprise for all events of this registration's event's programme to not_eligible.
				$enterprise_id = $registration->enterprise_id;
            	self::set_siblings_not_eligible($registration, $enterprise_id, $programme_id);
			}
		# If disapproving the approval to participate
		} else {

			# Disapprove the registration
			$registration->update([
				'is_approved_to_participate' => $toggle_to_true
			]);

			notify('Registration\'s participation revoked.', ['icon' => 'circle-x']);

			# Delete any participation that might have been created when approved to participate
			self::delete_participation_if_exists($registration);

			# Set all other registrations of this enterprise for all events of this registration's event's programme to not_eligible 
			$enterprise_id = $registration->enterprise_id;
			$programme_id = $registration->event->programme->id;
            self::set_siblings_eligible($registration, $enterprise_id, $programme_id);
		}

		return redirect()->back();
    }

    private static function capacity_full(Registration $registration): bool
    {
        $event = $registration->event;
        $participant_count = $event->participant_count ?? 0;
        $current_participations = $event->registrations()->whereHas('participation')->count();
        return $current_participations >= $participant_count;
    }

    private static function ensure_participation_exists(Registration $registration): void
    {
        if (! $registration->participation) {
            $registration->participation()->create([
                'registration_id' 	=> $registration->id,
				'participation'		=> true
            ]);
        }
    }

    private static function delete_participation_if_exists(Registration $registration): void
    {
        if ($registration->participation) {
            $registration->participation->delete();
        }
    }

    private static function set_siblings_not_eligible(Registration $registration, int $enterprise_id, int $programme_id): void
    {
        Registration::where('enterprise_id', $enterprise_id)
            ->where('id', '!=', $registration->id)
            ->where('is_eligible_to_participate', true)
            ->whereHas('event', function ($query) use ($programme_id) {
                $query->where('programme_id', $programme_id);
            })
            ->update(['is_eligible_to_participate' => false]);
    }

    private static function set_siblings_eligible(Registration $registration, int $enterprise_id, int $programme_id): void
    {
        Registration::where('enterprise_id', $enterprise_id)
            ->whereHas('event', function ($query) use ($programme_id) {
                $query->where('programme_id', $programme_id);
            })
            ->update(['is_eligible_to_participate' => true]);
    }
}