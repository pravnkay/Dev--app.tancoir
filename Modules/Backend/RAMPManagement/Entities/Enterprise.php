<?php

namespace Modules\Backend\RAMPManagement\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Modules\Backend\RAMPManagement\Observers\EnterpriseObserver;

use Modules\Core\Core\Enums\ContactDesignationEnum;
use Modules\Core\Core\Enums\DistrictEnum;
use Modules\Core\Core\Traits\Userstamps;

#[ObservedBy([EnterpriseObserver::class])]
class Enterprise extends Model
{
	use Userstamps;
	
	protected $table 	= "ramp_enterprises";

	protected $guarded 	= [];

	protected $casts 	= [
		'district'					=> DistrictEnum::class,
		'contact_designation'		=> ContactDesignationEnum::class,
        'is_a_valid_enterprise'		=> 'boolean',
	];

	public function registrations() :HasMany
	{
		return $this->hasMany(EventRegistration::class);
	}
}
