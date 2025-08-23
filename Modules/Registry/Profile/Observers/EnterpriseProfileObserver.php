<?php
 
namespace Modules\Registry\Profile\Observers;

use Modules\Registry\Profile\Entities\EnterpriseProfile;

class EnterpriseProfileObserver
{
    /**
     * Handle the EnterpriseProfile "created" event.
     */
    public function created(EnterpriseProfile $profile): void
    {
       //
    }
 
    /**
     * Handle the EnterpriseProfile "updated" event.
     */
    public function updated(EnterpriseProfile $profile): void
    {
		$user = $profile->user;

        if ($user->active_profile_id == $profile->id && $user->active_profile_type == $profile->getMorphClass()) {
			$user->update([
				'active_profile_id' => null,
				'active_profile_type' => null
			]);
		}

    }
 
    /**
     * Handle the EnterpriseProfile "deleted" event.
     */
    public function deleted(EnterpriseProfile $profile): void
    {
        $user = $profile->user;
            
		// If this profile was the active one, clear the active profile
		if ($user->active_profile_id == $profile->id && $user->active_profile_type == $profile->getMorphClass()) {			
			$user->update([
				'active_profile_id' => null,
				'active_profile_type' => null
			]);
		}
    }
 
    /**
     * Handle the EnterpriseProfile "restored" event.
     */
    public function restored(EnterpriseProfile $profile): void
    {
        // ...
    }
 
    /**
     * Handle the EnterpriseProfile "forceDeleted" event.
     */
    public function forceDeleted(EnterpriseProfile $profile): void
    {
        // ...
    }
}