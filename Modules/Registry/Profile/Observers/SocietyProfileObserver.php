<?php
 
namespace Modules\Registry\Profile\Observers;

use Modules\Registry\Profile\Entities\SocietyProfile;

class SocietyProfileObserver
{
    /**
     * Handle the SocietyProfile "created" event.
     */
    public function created(SocietyProfile $profile): void
    {
       //
    }
 
    /**
     * Handle the SocietyProfile "updated" event.
     */
    public function updated(SocietyProfile $profile): void
    {
        // ...
    }
 
    /**
     * Handle the SocietyProfile "deleted" event.
     */
    public function deleted(SocietyProfile $profile): void
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
     * Handle the SocietyProfile "restored" event.
     */
    public function restored(SocietyProfile $profile): void
    {
        // ...
    }
 
    /**
     * Handle the SocietyProfile "forceDeleted" event.
     */
    public function forceDeleted(SocietyProfile $profile): void
    {
        // ...
    }
}