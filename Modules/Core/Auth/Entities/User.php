<?php

namespace Modules\Core\Auth\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Core\Core\Enums\ProfileTypeEnum;
use Modules\Registry\Profile\Entities\ClusterProfile;
use Modules\Registry\Profile\Entities\EnterpriseProfile;
use Modules\Registry\Profile\Entities\SocietyProfile;
use Modules\Registry\Profile\Entities\AssociationProfile;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

	protected $table = 'acl_users';

    protected $fillable = [
        'name',
        'email',
        'password',
		'active_profile_id',
		'active_profile_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function getAvatarAttribute()
	{
		$name = $this->name;
		return 'https://ui-avatars.com/api/?name='.urlencode($name);
	}

	public static function boot()
	{
		parent::boot();
		self::creating(function ($user) {
			$user->username = \Str::slug($user->name, "");
		});
		self::updating(function ($user) {
			$user->username = \Str::slug($user->name, "");
		});
	}

    public function activeProfile(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'active_profile_type', 'active_profile_id');
    }

	public function getActiveProfileTypeStringAttribute(): ?string
	{
		if (!$this->activeProfile) {
			return null;
		}
		
		foreach (ProfileTypeEnum::cases() as $case) {
			if ($case->classDefinition() === $this->active_profile_type) {
				return strtolower($case->value);
			}
		}
		
		return null;
	}


    public function enterpriseProfiles(): HasMany
    {
        return $this->hasMany(EnterpriseProfile::class);
    }

    public function clusterProfiles(): HasMany
    {
        return $this->hasMany(ClusterProfile::class);
    }

    public function societyProfiles(): HasMany
    {
        return $this->hasMany(SocietyProfile::class);
    }

    public function associationProfiles(): HasMany
    {
        return $this->hasMany(AssociationProfile::class);
    }

    // --- Helper method to get all profiles combined ---
    public function allProfiles()
    {
        // Eager load all profile types to avoid N+1 issues
        $this->loadMissing(['enterpriseProfiles', 'clusterProfiles', 'societyProfiles', 'associationProfiles']);

        $enterpriseProfiles = $this->enterpriseProfiles->each(function ($profile) {
			$profile->profile_type_enum = ProfileTypeEnum::ENTERPRISE;
			return $profile;
		});
		
		$clusterProfiles = $this->clusterProfiles->each(function ($profile) {
			$profile->profile_type_enum = ProfileTypeEnum::CLUSTER;
			return $profile;
		});
		
		$societyProfiles = $this->societyProfiles->each(function ($profile) {
			$profile->profile_type_enum = ProfileTypeEnum::SOCIETY;
			return $profile;
		});

		$associationProfiles = $this->associationProfiles->each(function ($profile) {
			$profile->profile_type_enum = ProfileTypeEnum::ASSOCIATION;
			return $profile;
		});
	
		return $enterpriseProfiles->concat($clusterProfiles)->concat($societyProfiles)->concat($associationProfiles);
    }

	public function isProfileActive($profile): bool
	{
		return $this->active_profile_id == $profile->id && 
			$this->active_profile_type == $profile->getMorphClass();
	}

	public function profilesForAdmin()
	{
		return $this->allProfiles()->filter(function ($profile) {
			return $profile->checkStatus('admin_visible');
		});
	}

	public function submittedProfiles()
	{
		return $this->allProfiles()->filter(function ($profile) {
			return $profile->checkStatus('submitted');
		});
	}

	public function approvedProfiles()
	{
		return $this->allProfiles()->filter(function ($profile) {
			return $profile->checkStatus('approved');
		});
	}

	public function draftProfiles()
	{
		return $this->allProfiles()->filter(function ($profile) {
			return $profile->checkStatus('draft');
		});
	}

	public function returnedProfiles()
	{
		return $this->allProfiles()->filter(function ($profile) {
			return $profile->checkStatus('returned');
		});
	}
}
