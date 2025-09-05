<?php
 
namespace Modules\Backend\RAMPManagement\Observers;

use Modules\Backend\RAMPManagement\Entities\Vertical;

class VerticalObserver
{
    /**
     * Handle the Vertical "created" event.
     */
    public function creating(Vertical $vertical): void
    {
		$allocated_funds = (float) $vertical->allocated_funds;
        $utilised_funds  = (float) $vertical->utilised_funds;
        $vertical->remaining_funds = $allocated_funds - $utilised_funds;
    }
 
    /**
     * Handle the Vertical "updated" event.
     */
    public function updating(Vertical $vertical): void
    {
		$allocated_funds = (float) $vertical->allocated_funds;
        $utilised_funds  = (float) $vertical->utilised_funds;
        $vertical->remaining_funds = $allocated_funds - $utilised_funds;
    }
 
    /**
     * Handle the Vertical "deleted" event.
     */
    public function deleted(Vertical $vertical): void
    {
        //
    }
 
    /**
     * Handle the Vertical "restored" event.
     */
    public function restored(Vertical $vertical): void
    {
        // ...
    }
 
    /**
     * Handle the Vertical "forceDeleted" event.
     */
    public function forceDeleted(Vertical $vertical): void
    {
        // ...
    }
}