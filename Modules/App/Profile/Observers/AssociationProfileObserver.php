<?php
 
namespace Modules\App\Profile\Observers;

use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\App\Profile\Entities\AssociationProfile;

class AssociationProfileObserver
{
    /**
     * Handle the AssociationProfile "created" event.
     */
    public function created(AssociationProfile $association_profile): void
    {
       //
    }
 
    /**
     * Handle the AssociationProfile "updated" event.
     */
    public function updated(AssociationProfile $association_profile): void
    {
        if($association_profile->isComplete()) {
			$association_profile->profile->updateQuietly([
				'status' => ProfileStatusEnum::SUBMITTED->value,
				'is_active' => false,
				'submitted_at' => now(),
			]);
		} else {
			$association_profile->profile->updateQuietly([
				'status' => ProfileStatusEnum::DRAFT->value,
				'is_active' => false,
				'submitted_at' => null,
			]);
		}
    }
 
    /**
     * Handle the AssociationProfile "deleted" event.
     */
    public function deleted(AssociationProfile $association_profile): void
    {
        //
    }
 
    /**
     * Handle the AssociationProfile "restored" event.
     */
    public function restored(AssociationProfile $association_profile): void
    {
        // ...
    }
 
    /**
     * Handle the AssociationProfile "forceDeleted" event.
     */
    public function forceDeleted(AssociationProfile $association_profile): void
    {
        // ...
    }
}