<?php
 
 namespace Modules\Backend\RAMPManagement\Observers;

use Modules\Backend\RAMPManagement\Entities\EventRegistration;

class EventRegistrationObserver
{
    /**
     * Handle the EventRegistration "creating" event.
     */
    public function creating(EventRegistration $event_registration): void
    {
		//
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