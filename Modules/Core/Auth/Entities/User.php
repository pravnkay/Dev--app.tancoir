<?php

namespace Modules\Core\Auth\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

}
