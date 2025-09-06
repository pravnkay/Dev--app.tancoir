<?php

namespace Modules\Backend\RAMPManagement\Observers;

use Modules\Backend\RAMPManagement\Entities\EventParticipation;

class EventParticipationObserver
{
    /**
     * Handle the EventParticipation "created" event.
     */
    public function created(EventParticipation $event_participation): void
    {
        //
    }

    /**
     * Handle the EventParticipation "updated" event.
     */
    public function updated(EventParticipation $event_participation): void
    {
        //
    }

    /**
     * Handle the EventParticipation "deleted" event.
     */
    public function deleted(EventParticipation $event_participation): void
    {
        //
    }

    /**
     * Handle the EventParticipation "restored" event.
     */
    public function restored(EventParticipation $event_participation): void
    {
        //
    }

    /**
     * Handle the EventParticipation "force deleted" event.
     */
    public function forceDeleted(EventParticipation $event_participation): void
    {
        //
    }
}

