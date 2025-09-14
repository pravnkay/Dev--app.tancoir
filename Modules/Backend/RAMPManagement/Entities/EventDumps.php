<?php

namespace Modules\Backend\RAMPManagement\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

use Modules\Backend\RAMPManagement\Observers\EventDumpObserver;
use Modules\Core\Core\Traits\Userstamps;

#[ObservedBy([EventDumpObserver::class])]
class EventDump extends Model
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
