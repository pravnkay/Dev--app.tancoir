<?php
 
 namespace Modules\Backend\RAMPManagement\Observers;

use Modules\Backend\RAMPManagement\Entities\EventDump;

class EventDumpObserver
{
    /**
     * Handle the EventDump "creating" event.
     */
    public function creating(EventDump $event_dump): void
    {
		//
    }

    /**
     * Handle the EventDump "created" event.
     */
    public function created(EventDump $event_dump): void
    {
		//
    }
 
    /**
     * Handle the EventDump "updating" event.
     */
    public function updating(EventDump $event_dump): void
    {
        //
    }

    /**
     * Handle the EventDump "updated" event.
     */
    public function updated(EventDump $event_dump): void
    {
        //
    }
 
    /**
     * Handle the EventDump "deleted" event.
     */
    public function deleted(EventDump $event_dump): void
    {
        //
    }

}