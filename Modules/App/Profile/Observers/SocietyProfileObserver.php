<?php
 
namespace Modules\App\Profile\Observers;

use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\App\Profile\Entities\SocietyProfile;

class SocietyProfileObserver
{
    /**
     * Handle the SocietyProfile "created" event.
     */
    public function created(SocietyProfile $society_profile): void
    {
       //
    }
 
    /**
     * Handle the SocietyProfile "updated" event.
     */
    public function updated(SocietyProfile $society_profile): void
    {
        if($society_profile->isComplete()) {
			$society_profile->profile->updateQuietly([
				'status' => ProfileStatusEnum::SUBMITTED->value,
				'is_active' => false,
				'submitted_at' => now(),
			]);
		} else {
			$society_profile->profile->updateQuietly([
				'status' => ProfileStatusEnum::DRAFT->value,
				'is_active' => false,
				'submitted_at' => null,
			]);
		}
    }
 
    /**
     * Handle the SocietyProfile "deleted" event.
     */
    public function deleted(SocietyProfile $society_profile): void
    {
       //
    }
 
    /**
     * Handle the SocietyProfile "restored" event.
     */
    public function restored(SocietyProfile $society_profile): void
    {
        // ...
    }
 
    /**
     * Handle the SocietyProfile "forceDeleted" event.
     */
    public function forceDeleted(SocietyProfile $society_profile): void
    {
        // ...
    }
}