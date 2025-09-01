<?php

namespace Modules\Backend\RAMPManagement\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

use Modules\Backend\RAMPManagement\Observers\EventObserver;
use Modules\Core\Core\Traits\Userstamps;

#[ObservedBy([EventObserver::class])]
class Event extends Model
{
	use Userstamps;
	
	protected $table 			= "ramp_events";
	public $uploader_redirect 	= 'backend.rampmanagement.events.index';

    protected $fillable = [
		'programme_id',
		'name',
		'title',
		'iteration',
		'date',
		'days',
		'cost',
		'participant_count',
		'participant_cost',
	];

	protected $casts = [
        'date'				=> 'datetime:d/m/Y',
        'cost'				=> 'decimal:2',
        'participant_cost'	=> 'decimal:2',
    ];

	public function programme()
	{
		return $this->belongsTo(Programme::class);
	}
}
