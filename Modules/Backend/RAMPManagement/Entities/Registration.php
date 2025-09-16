<?php

namespace Modules\Backend\RAMPManagement\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Modules\Backend\RAMPManagement\Observers\RegistrationObserver;

use Modules\Core\Core\Traits\Userstamps;

#[ObservedBy([RegistrationObserver::class])]
class Registration extends Model
{
	use Userstamps;
	
	protected $table 			= "ramp_registrations";

	protected $guarded = [];

	protected $casts = [
       'registration_data' => 'array'
    ];

	public function event() :BelongsTo
	{
		return $this->belongsTo(Event::class);
	}

	public function enterprise() :BelongsTo
	{
		return $this->belongsTo(Enterprise::class);
	}
}
