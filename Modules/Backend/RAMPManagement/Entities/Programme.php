<?php

namespace Modules\Backend\RAMPManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

	public function vertical() :BelongsTo
	{
		return $this->belongsTo(Vertical::class);
	}

	public function events() :HasMany
	{
		return $this->hasMany(Event::class);
	}
}
