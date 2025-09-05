<?php
 
namespace Modules\App\Profile\Observers;

use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\App\Profile\Entities\EnterpriseProfile;

class EnterpriseProfileObserver
{
    /**
     * Handle the EnterpriseProfile "created" event.
     */
    public function created(EnterpriseProfile $enterprise_profile): void
    {
       //
    }
 
    /**
     * Handle the EnterpriseProfile "updated" event.
     */
    public function updated(EnterpriseProfile $enterprise_profile): void
    {
		if($enterprise_profile->isComplete()) {
			$enterprise_profile->profile->updateQuietly([
				'status' => ProfileStatusEnum::SUBMITTED->value,
				'is_active' => false,
				'submitted_at' => now(),
			]);
		} else {
			$enterprise_profile->profile->updateQuietly([
				'status' => ProfileStatusEnum::DRAFT->value,
				'is_active' => false,
				'submitted_at' => null,
			]);
		}
    }
 
    /**
     * Handle the EnterpriseProfile "deleted" event.
     */
    public function deleted(EnterpriseProfile $enterprise_profile): void
    {
        //
    }
 
    /**
     * Handle the EnterpriseProfile "restored" event.
     */
    public function restored(EnterpriseProfile $enterprise_profile): void
    {
        // ...
    }
 
    /**
     * Handle the EnterpriseProfile "forceDeleted" event.
     */
    public function forceDeleted(EnterpriseProfile $enterprise_profile): void
    {
        // ...
    }
}