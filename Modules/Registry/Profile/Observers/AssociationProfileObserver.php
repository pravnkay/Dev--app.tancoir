<?php
 
namespace Modules\Registry\Profile\Observers;

use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\Registry\Profile\Entities\AssociationProfile;

class AssociationProfileObserver
{
    /**
     * Handle the AssociationProfile "created" event.
     */
    public function created(AssociationProfile $profile): void
    {
       //
    }
 
    /**
     * Handle the AssociationProfile "updated" event.
     */
    public function updated(AssociationProfile $profile): void
    {
        $user = $profile->user;

        if ($user->active_profile_id == $profile->id && $user->active_profile_type == $profile->getMorphClass()) {
			$user->update([
				'active_profile_id' => null,
				'active_profile_type' => null
			]);
		}

		if($profile->isComplete()) {
			$profile->updateQuietly([
				'status' => ProfileStatusEnum::SUBMITTED->value,
				'submitted_at' => now(),
			]);
		}
    }
 
    /**
     * Handle the AssociationProfile "deleted" event.
     */
    public function deleted(AssociationProfile $profile): void
    {
        $user = $profile->user;
            
		// If this profile was the active one, clear the active profile
		if ($user->active_profile_id == $profile->id && 
			$user->active_profile_type == $profile->getMorphClass()) {
			
			$user->update([
				'active_profile_id' => null,
				'active_profile_type' => null
			]);
		}
    }
 
    /**
     * Handle the AssociationProfile "restored" event.
     */
    public function restored(AssociationProfile $profile): void
    {
        // ...
    }
 
    /**
     * Handle the AssociationProfile "forceDeleted" event.
     */
    public function forceDeleted(AssociationProfile $profile): void
    {
        // ...
    }
}