<?php
 
 namespace Modules\Backend\RAMPManagement\Observers;

use Modules\Backend\RAMPManagement\Actions\Registrations\ToggleEligibleToParticipate;
use Modules\Backend\RAMPManagement\Entities\Enterprise;

class EnterpriseObserver
{
    /**
     * Handle the Enterprise "creating" event.
     */
    public function creating(Enterprise $enterprise): void
    {
		//
    }

    /**
     * Handle the Enterprise "created" event.
     */
    public function created(Enterprise $enterprise): void
    {
		//
    }
 
    /**
     * Handle the Enterprise "updating" event.
     */
    public function updating(Enterprise $enterprise): void
    {
		//
    }

    /**
     * Handle the Enterprise "updated" event.
     */
    public function updated(Enterprise $enterprise): void
    {
		if ($enterprise->wasChanged('is_a_valid_enterprise')) {
			$registrations = $enterprise->registrations()->get();
			foreach ($registrations as $registration) {
				ToggleEligibleToParticipate::run($registration);
			}
		}
    }
 
    /**
     * Handle the Enterprise "deleted" event.
     */
    public function deleted(Enterprise $enterprise): void
    {
        //
    }

}