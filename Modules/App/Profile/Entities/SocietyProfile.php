<?php

namespace Modules\App\Profile\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Modules\Core\Auth\Entities\User;
use Modules\Core\Core\Traits\Userstamps;
use Modules\App\Profile\Observers\SocietyProfileObserver;

use Modules\Core\Core\Enums\DistrictEnum;

#[ObservedBy([SocietyProfileObserver::class])]
class SocietyProfile extends Model
{
	use Userstamps;
	
	protected $table = "profile_society_profiles";

    protected $guarded = [];

	protected $requiredForSubmission = [
        'udyam',
        'society_name',
        'society_place',
        'society_district',
        'contact_person_name',
        'contact_email',
        'contact_phone',
        'contact_whatsapp',
    ];

	protected $casts = [
		'district' 	=> DistrictEnum::class,
    ];

	public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

	public function profile()
    {
        return $this->belongsTo(Profile::class);
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
