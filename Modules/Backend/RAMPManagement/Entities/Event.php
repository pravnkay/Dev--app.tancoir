<?php

namespace Modules\Backend\RAMPManagement\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Modules\Backend\RAMPManagement\Observers\EventObserver;
use Modules\Backend\RAMPManagement\Entities\EventRegistration;

use Modules\Core\Core\Traits\Userstamps;

#[ObservedBy([EventObserver::class])]
class Event extends Model
{
	use Userstamps;
	
	protected $table 			= "ramp_events";
	public $uploader_redirect 	= 'backend.rampmanagement.events.index';

	protected $guarded = [];

	protected $casts = [
        'date'				=> 'datetime:d/m/Y',
        'cost'				=> 'decimal:2',
        'participant_cost'	=> 'decimal:2',
    ];

	public function programme() :BelongsTo
	{
		return $this->belongsTo(Programme::class);
	}

	public function event_form() :HasOne
	{
		return $this->hasOne(EventForm::class);
	}

	public function registrations() :HasMany
	{
		return $this->hasMany(EventRegistration::class);
	}

	public function participations() :HasManyThrough
	{
		return $this->hasManyThrough(EventParticipation::class, EventRegistration::class);
	}
}
