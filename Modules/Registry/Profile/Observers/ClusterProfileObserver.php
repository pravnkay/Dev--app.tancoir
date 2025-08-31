<?php
 
namespace Modules\Registry\Profile\Observers;

use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\Registry\Profile\Entities\ClusterProfile;

class ClusterProfileObserver
{
    /**
     * Handle the ClusterProfile "created" event.
     */
    public function created(ClusterProfile $profile): void
    {
       //
    }
 
    /**
     * Handle the ClusterProfile "updated" event.
     */
    public function updated(ClusterProfile $profile): void
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
     * Handle the ClusterProfile "deleted" event.
     */
    public function deleted(ClusterProfile $profile): void
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
     * Handle the ClusterProfile "restored" event.
     */
    public function restored(ClusterProfile $profile): void
    {
        // ...
    }
 
    /**
     * Handle the ClusterProfile "forceDeleted" event.
     */
    public function forceDeleted(ClusterProfile $profile): void
    {
        // ...
    }
}