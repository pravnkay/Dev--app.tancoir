<?php
 
 namespace Modules\Backend\RAMPManagement\Observers;

use Illuminate\Support\Str;
use Modules\Backend\RAMPManagement\Entities\Enterprise;
use Modules\Backend\RAMPManagement\Entities\EventRegistration;
use Modules\Core\Core\Enums\ContactDesignationEnum;

class EventRegistrationObserver
{
    /**
     * Handle the EventRegistration "creating" event.
     */
    public function creating(EventRegistration $event_registration): void
    {
		Enterprise::firstOrCreate(
			['udyam' => $event_registration->registration_data['உதயம் எண் / UDYAM No. (Format: UDYAM-TN-00-0000000)']],
			[
				'name'					=> Str::of($event_registration->registration_data['நிறுவனத்தின் பெயர் / Company Name'])->replace('.', ' ')->upper()->squish()->toString(),
				'place'					=> Str::of($event_registration->registration_data['ஊர் / Place'])->replace('.', ' ')->squish()->title()->toString(),
				'district'				=> Str::of($event_registration->registration_data['மாவட்டம் / District'])->before('/')->lower()->replaceMatches('/[^a-z]+/u', ' ')->squish()->replace(' ', '_')->toString(),
				'contact_name'			=> Str::of($event_registration->registration_data['ஒப்புக்கொள்ளும் நபர் பெயர் / Name'])->replace('.', ' ')->squish()->title()->toString(),
				'contact_designation'	=> ContactDesignationEnum::from_label($event_registration->registration_data['ஒப்புக்கொள்பவரின் நிறுவன பொறுப்பு / Designation'])->value,
				'contact_email'			=> $event_registration->registration_data['Email Address'],
			]
		);
    }

    /**
     * Handle the EventRegistration "created" event.
     */
    public function created(EventRegistration $event_registration): void
    {
		//
    }
 
    /**
     * Handle the EventRegistration "updating" event.
     */
    public function updating(EventRegistration $event_registration): void
    {
        //
    }

    /**
     * Handle the EventRegistration "updated" event.
     */
    public function updated(EventRegistration $event_registration): void
    {
        //
    }
 
    /**
     * Handle the EventRegistration "deleted" event.
     */
    public function deleted(EventRegistration $event_registration): void
    {
        //
    }

}