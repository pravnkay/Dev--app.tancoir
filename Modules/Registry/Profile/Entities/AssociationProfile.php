<?php

namespace Modules\Registry\Profile\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Modules\Core\Auth\Entities\User;
use Modules\Core\Core\Traits\Userstamps;
use Modules\Registry\Profile\Observers\AssociationProfileObserver;

use Modules\Core\Core\Enums\DistrictEnum;
use Modules\Core\Core\Enums\ProfileStatusEnum;

#[ObservedBy([AssociationProfileObserver::class])]
class AssociationProfile extends Model
{
	use Userstamps;
	
	protected $table = "profile_association_profiles";

    protected $guarded = [];

	protected $requiredForSubmission = [
        'name',
        'udyam',
        'association_name',
        'association_place',
        'association_district',
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
