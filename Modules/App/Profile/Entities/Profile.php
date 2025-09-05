<?php

namespace Modules\App\Profile\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Core\Auth\Entities\User;
use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\Core\Core\Enums\ProfileTypeEnum;

class Profile extends Model
{
    protected $table = 'profile_profiles';
    protected $guarded = [];

	protected $casts = [
		'type' => ProfileTypeEnum::class,
		'status' => ProfileStatusEnum::class,
		'is_active' => 'boolean'
	];

	public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function association_profile() :HasOne
    {
        return $this->hasOne(AssociationProfile::class);
    }
    
    public function cluster_profile() :HasOne
    {
        return $this->hasOne(ClusterProfile::class);
    }
    
    public function enterprise_profile() :HasOne
    {
        return $this->hasOne(EnterpriseProfile::class);
    }
    
    public function society_profile() :HasOne
    {
        return $this->hasOne(SocietyProfile::class);
    }
    
    public function getProfileDataAttribute()
    {
        return match($this->type->value) {
            'association' 	=> $this->association_profile,
            'cluster' 		=> $this->cluster_profile,
            'enterprise' 	=> $this->enterprise_profile,
            'society' 		=> $this->society_profile,
        };
    }
}

