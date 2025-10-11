<?php

namespace Modules\Core\Auth\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\App\Profile\Entities\Participant;
use Modules\App\Profile\Entities\Profile;
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

	public function profiles() :HasMany
    {
        return $this->hasMany(Profile::class);
    }

	public function participants() :HasMany
    {
        return $this->hasMany(Participant::class);
    }
    
    public function activeProfiles() :HasMany
    {
        return $this->hasMany(Profile::class)->where('is_active', true);
    }

	public function allProfiles()
	{
		return $this->profiles()
				->with([
						'association_profile',
						'cluster_profile',
						'enterprise_profile',
						'society_profile',
				])->get();
	}

	public function allApprovedProfiles()
	{
		return $this->profiles()
			->approved()
			->with([
				'association_profile',
				'cluster_profile',
				'enterprise_profile',
				'society_profile',
			])
			->get();
	}

	public function allParticipants()
	{
		return $this->participants()->get();
	}

}
