<?php
 
 namespace Modules\Backend\RAMPManagement\Observers;

use Modules\Backend\RAMPManagement\Entities\Registration;

class RegistrationObserver
{
    /**
     * Handle the Registration "creating" event.
     */
    public function creating(Registration $registration): void
    {
		//
    }

    /**
     * Handle the Registration "created" event.
     */
    public function created(Registration $registration): void
    {
		//
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
        $event_id = $registration->event_id;
				
		$next_registration = Registration::where('event_id', $event_id)
		->where('is_approved_to_participate', false)
		->orderBy('registration_serial')
		->first();

		if ($next_registration) {
			$next_registration->forceFill([
				'is_approved_to_participate' => true,
			])->save();
		}		

    }

}