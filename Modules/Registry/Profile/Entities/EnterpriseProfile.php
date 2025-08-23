<?php

namespace Modules\Registry\Profile\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Modules\Core\Auth\Entities\User;
use Modules\Core\Core\Enums\DistrictEnum;
use Modules\Core\Core\Traits\Userstamps;
use Modules\Registry\Profile\Observers\EnterpriseProfileObserver;

use Modules\Core\Core\Enums\ProfileStatusEnum;

#[ObservedBy([EnterpriseProfileObserver::class])]
class EnterpriseProfile extends Model
{
	use Userstamps;
	
	protected $table = "profile_enterprise_profiles";

    protected $guarded = [];

	protected $casts = [
		'district' 	=> DistrictEnum::class,
		'status'	=> ProfileStatusEnum::class
    ];

	public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
