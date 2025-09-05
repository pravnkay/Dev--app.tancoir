<?php

namespace Modules\App\Profile\Actions\Participants;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\App\Profile\Entities\Participant;

use Modules\Core\Core\Enums\ParticipantDesignationEnum;
use Modules\Core\Core\Enums\ParticipantGenderEnum;
use Modules\Core\Core\Enums\ParticipantReligionEnum;
use Modules\Core\Core\Enums\ParticipantCommunityEnum;

class Show
{
	use AsAction;

	public function handle(Participant $participant)
    {
		return view('profile::participant.show')->with([
			'participant'			=> $participant,
			'designations' 			=> ParticipantDesignationEnum::asArray(),
			'genders' 				=> ParticipantGenderEnum::asArray(),
			'religions' 			=> ParticipantReligionEnum::asArray(),
			'communities' 			=> ParticipantCommunityEnum::asArray(),
			'active_profiles' 		=> Auth::user()->activeProfiles()->pluck('name', 'id')->toArray(),
		]);

    }
}