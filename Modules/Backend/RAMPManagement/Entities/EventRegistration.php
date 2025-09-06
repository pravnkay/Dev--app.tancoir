<?php

namespace Modules\Backend\RAMPManagement\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Backend\RAMPManagement\Observers\EventRegistrationObserver;
use Modules\Core\Core\Traits\Userstamps;

#[ObservedBy([EventRegistrationObserver::class])]
class EventRegistration extends Model
{
	use Userstamps;
	
	protected $table = "ramp_event_registrations";

	protected $guarded = [];

	protected $casts = [
       //
    ];

	public function event()
	{
		return $this->belongsTo(Event::class);
	}

	public function user()
	{
		return $this->belongsTo(\Modules\Core\Auth\Entities\User::class);
	}

	public function profile()
	{
		return $this->belongsTo(\Modules\App\Profile\Entities\Profile::class);
	}

	public function participant()
	{
		return $this->belongsTo(\Modules\App\Profile\Entities\Participant::class);
	}

	public function eventParticipation() :HasOne
	{
		return $this->hasOne(EventParticipation::class);
	}
}
