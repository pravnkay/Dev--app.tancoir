<?php

namespace Modules\Backend\RAMPManagement\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Modules\Backend\RAMPManagement\Observers\EventParticipationObserver;
use Modules\Core\Core\Traits\Userstamps;

#[ObservedBy([EventParticipationObserver::class])]
class EventParticipation extends Model
{
	use Userstamps;
	
	protected $table = "ramp_event_participations";

	protected $guarded = [];

	protected $casts = [
		'has_participated' => 'boolean',
		'has_feedbacked' => 'boolean',
    ];

	public function event_registration() :BelongsTo
	{
		return $this->belongsTo(EventRegistration::class);
	}

	public function event()
	{
		return $this->eventRegistration->event();
	}

	public function user()
	{
		return $this->eventRegistration->user();
	}

	public function profile()
	{
		return $this->eventRegistration->profile();
	}

	public function participant()
	{
		return $this->eventRegistration->participant();
	}
}
