<?php
 
namespace Modules\App\Profile\Observers;

use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\App\Profile\Entities\ClusterProfile;

class ClusterProfileObserver
{
    /**
     * Handle the ClusterProfile "created" event.
     */
    public function created(ClusterProfile $cluster_profile): void
    {
       //
    }
 
    /**
     * Handle the ClusterProfile "updated" event.
     */
    public function updated(ClusterProfile $cluster_profile): void
    {
        if($cluster_profile->isComplete()) {
			$cluster_profile->profile->updateQuietly([
				'status' => ProfileStatusEnum::SUBMITTED->value,
				'is_active' => false,
				'submitted_at' => now(),
			]);
		} else {
			$cluster_profile->profile->updateQuietly([
				'status' => ProfileStatusEnum::DRAFT->value,
				'is_active' => false,
				'submitted_at' => null,
			]);
		}
    }
 
    /**
     * Handle the ClusterProfile "deleted" event.
     */
    public function deleted(ClusterProfile $cluster_profile): void
    {
        //
    }
 
    /**
     * Handle the ClusterProfile "restored" event.
     */
    public function restored(ClusterProfile $cluster_profile): void
    {
        // ...
    }
 
    /**
     * Handle the ClusterProfile "forceDeleted" event.
     */
    public function forceDeleted(ClusterProfile $cluster_profile): void
    {
        // ...
    }
}