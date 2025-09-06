<?php
 
namespace Modules\App\Profile\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\App\Profile\Entities\Participant;

class ParticipantObserver
{
    /**
     * Handle the Participant "created" event.
     */
    public function creating(Participant $participant): void
    {
       $participant->user_id = Auth::user()->id;
    }

    /**
     * Handle the Participant "created" event.
     */
    public function created(Participant $participant): void
    {
       //
    }

	/**
     * Handle the Participant "created" event.
     */
    public function retrieved(Participant $participant): void
    {
       //
    }
 
    /**
     * Handle the Participant "updated" event.
     */
    public function updated(Participant $participant): void
    {
       //
    }
 
    /**
     * Handle the Participant "deleted" event.
     */
    public function deleted(Participant $participant): void
    {
        //
    }
 
    /**
     * Handle the Participant "restored" event.
     */
    public function restored(Participant $participant): void
    {
        // ...
    }
 
    /**
     * Handle the Participant "forceDeleted" event.
     */
    public function forceDeleted(Participant $participant): void
    {
        // ...
    }
}