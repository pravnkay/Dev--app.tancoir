<?php

namespace Modules\Backend\RAMPManagement\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

use Modules\Backend\RAMPManagement\Observers\EventFormObserver;
use Modules\Core\Core\Traits\Userstamps;

#[ObservedBy([EventFormObserver::class])]
class EventForm extends Model
{
	use Userstamps;
	
	protected $table 			= "ramp_event_forms";

	protected $guarded = [];

	protected $casts = [
       //
    ];

	public function event()
	{
		return $this->belongsTo(Event::class);
	}
}
