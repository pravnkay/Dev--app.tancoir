<?php

namespace Modules\Registry\Profile\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Modules\Core\Auth\Entities\User;
use Modules\Core\Core\Traits\Userstamps;
use Modules\Registry\Profile\Observers\EnterpriseProfileObserver;

use Modules\Core\Core\Enums\DistrictEnum;
use Modules\Core\Core\Enums\ProfileStatusEnum;

#[ObservedBy([EnterpriseProfileObserver::class])]
class EnterpriseProfile extends Model
{
	use Userstamps;
	
	protected $table = "profile_enterprise_profiles";

    protected $guarded = [];

	protected $requiredForSubmission = [
        'name',
        'udyam',
        'enterprise_name',
        'enterprise_place',
        'enterprise_district',
        'contact_person_name',
        'contact_email',
        'contact_phone',
        'contact_whatsapp',
    ];

	protected $casts = [
		'district' 	=> DistrictEnum::class,
		'status'	=> ProfileStatusEnum::class
    ];

	public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

	public function isComplete(): bool
    {
        foreach ($this->requiredForSubmission as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }
        return true;
    }

}
