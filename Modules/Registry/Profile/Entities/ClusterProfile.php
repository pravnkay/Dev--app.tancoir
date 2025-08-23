<?php

namespace Modules\Registry\Profile\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Modules\Core\Auth\Entities\User;
use Modules\Core\Core\Traits\Userstamps;
use Modules\Registry\Profile\Observers\ClusterProfileObserver;

use Makeable\QueryKit\QueryKit;
use Modules\Registry\Profile\Entities\Traits\HasProfileStatus;
use Makeable\EloquentStatus\HasStatus;

#[ObservedBy([ClusterProfileObserver::class])]
class ClusterProfile extends Model
{
	use Userstamps;
	use HasProfileStatus, QueryKit, HasStatus;
	
	protected $table = "profile_cluster_profiles";

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
		//
    ];

	public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

	public function getRequiredForSubmission(): array
    {
        return $this->requiredForSubmission;
    }

}
