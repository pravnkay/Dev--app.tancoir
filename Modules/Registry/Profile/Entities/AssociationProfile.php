<?php

namespace Modules\Registry\Profile\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Modules\Core\Auth\Entities\User;
use Modules\Core\Core\Traits\Userstamps;
use Modules\Registry\Profile\Observers\AssociationProfileObserver;

#[ObservedBy([AssociationProfileObserver::class])]
class AssociationProfile extends Model
{
	use Userstamps;
	
	protected $table = "profile_association_profiles";

    protected $guarded =[];

	protected $casts = [
		//
    ];

	public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
