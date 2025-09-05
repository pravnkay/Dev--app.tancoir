<?php
 
 namespace Modules\Backend\RAMPManagement\Observers;

use Modules\Backend\RAMPManagement\Entities\EventForm;

class EventFormObserver
{
    /**
     * Handle the EventForm "creating" event.
     */
    public function creating(EventForm $event_form): void
    {
		//
    }

    /**
     * Handle the EventForm "created" event.
     */
    public function created(EventForm $event_form): void
    {
		//
    }
 
    /**
     * Handle the EventForm "updating" event.
     */
    public function updating(EventForm $event_form): void
    {
        //
    }

    /**
     * Handle the EventForm "updated" event.
     */
    public function updated(EventForm $event_form): void
    {
        //
    }
 
    /**
     * Handle the EventForm "deleted" event.
     */
    public function deleted(EventForm $event_form): void
    {
        //
    }

}