<?php

namespace Modules\Backend\RAMPManagement\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Core\Core\Enums\ProgrammeSchemeEnum;

use Modules\Core\Core\Traits\Userstamps;

class Programme extends Model
{
	use Userstamps;
	
	protected $table 			= "ramp_programmes";
	public $uploader_redirect 	= 'backend.rampmanagement.programmes.index';

    protected $guarded = [];

	protected $casts = [
		'scheme' => ProgrammeSchemeEnum::class,
	];

	public function vertical()
	{
		return $this->belongsTo(Vertical::class);
	}

	public function events()
	{
		return $this->hasMany(Event::class);
	}
}
