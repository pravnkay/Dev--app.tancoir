<?php

namespace Modules\App\Profile\Entities;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Modules\App\Profile\Observers\ParticipantObserver;

use Modules\Core\Core\Enums\ParticipantCommunityEnum;
use Modules\Core\Core\Enums\ParticipantDesignationEnum;
use Modules\Core\Core\Enums\ParticipantGenderEnum;
use Modules\Core\Core\Enums\ParticipantReligionEnum;

#[ObservedBy([ParticipantObserver::class])]
class Participant extends Model
{
    protected $table = 'profile_participants';
    protected $guarded = [];

	protected $casts = [
		'designation'	=> ParticipantDesignationEnum::class,
		'gender'		=> ParticipantGenderEnum::class,
		'religion'		=> ParticipantReligionEnum::class,
		'community'		=> ParticipantCommunityEnum::class,
	];

	public function profile() :BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
    
}

