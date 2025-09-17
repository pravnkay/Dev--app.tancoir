<?php
 
 namespace Modules\Backend\RAMPManagement\Observers;

use Illuminate\Support\Str;
use Modules\Backend\RAMPManagement\Actions\Registrations\ToggleEligibleToParticipate;
use Modules\Backend\RAMPManagement\Entities\Enterprise;
use Modules\Backend\RAMPManagement\Entities\Registration;
use Modules\Core\Core\Enums\ContactDesignationEnum;

class RegistrationObserver
{
    /**
     * Handle the Registration "creating" event.
     */
    public function creating(Registration $registration): void
    {
		$enterprise = Enterprise::firstOrCreate(
			['udyam' => $registration->registration_data['உதயம் எண் / UDYAM No. (Format: UDYAM-TN-00-0000000)']],
			[
				'name'					=> Str::of($registration->registration_data['நிறுவனத்தின் பெயர் / Company Name'])->replace('.', ' ')->upper()->squish()->toString(),
				'place'					=> Str::of($registration->registration_data['ஊர் / Place'])->replace('.', ' ')->squish()->title()->toString(),
				'district'				=> Str::of($registration->registration_data['மாவட்டம் / District'])->before('/')->lower()->replaceMatches('/[^a-z]+/u', ' ')->squish()->replace(' ', '_')->toString(),
				'contact_name'			=> Str::of($registration->registration_data['ஒப்புக்கொள்ளும் நபர் பெயர் / Name'])->replace('.', ' ')->squish()->title()->toString(),
				'contact_designation'	=> ContactDesignationEnum::from_label($registration->registration_data['ஒப்புக்கொள்பவரின் நிறுவன பொறுப்பு / Designation'])->value,
				'contact_email'			=> $registration->registration_data['Email Address'],
			]
		);

		$registration->enterprise_id = $enterprise->id;
    }

    /**
     * Handle the Registration "created" event.
     */
    public function created(Registration $registration): void
    {
		ToggleEligibleToParticipate::run($registration);
    }
 
    /**
     * Handle the Registration "updating" event.
     */
    public function updating(Registration $registration): void
    {
        //
    }

    /**
     * Handle the Registration "updated" event.
     */
    public function updated(Registration $registration): void
    {
        //
    }
 
    /**
     * Handle the Registration "deleted" event.
     */
    public function deleted(Registration $registration): void
    {
        //
    }

}