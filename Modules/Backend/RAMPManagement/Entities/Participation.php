<?php

namespace Modules\Backend\RAMPManagement\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Modules\Backend\RAMPManagement\Observers\ParticipationObserver;

use Modules\Core\Core\Traits\Userstamps;

#[ObservedBy([ParticipationObserver::class])]
class Participation extends Model
{
	use Userstamps;
	
	protected $table 			= "ramp_participations";

	protected $guarded = [];

	protected $casts = [
       'participation' => 'boolean'
    ];

	public function registration() :BelongsTo
	{
		return $this->belongsTo(Registration::class);
	}
}
