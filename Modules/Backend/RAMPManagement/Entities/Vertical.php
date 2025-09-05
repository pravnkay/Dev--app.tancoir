<?php

namespace Modules\Backend\RAMPManagement\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

use Modules\Core\Core\Traits\Userstamps;
use Modules\Backend\RAMPManagement\Observers\VerticalObserver;

#[ObservedBy([VerticalObserver::class])]
class Vertical extends Model
{
	use Userstamps;
	
	protected $table 			= "ramp_verticals";
	public $uploader_redirect 	= 'backend.rampmanagement.verticals.index';

    protected $guarded 			= [];
	
	protected $casts 			= [
        'allocated_funds' => 'decimal:2',
        'utilised_funds'  => 'decimal:2',
        'remaining_funds' => 'decimal:2',
    ];

	public function programme()
	{
		return $this->hasMany(Programme::class);
	}
}
