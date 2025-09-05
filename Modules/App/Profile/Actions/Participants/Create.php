<?php

namespace Modules\App\Profile\Actions\Participants;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Core\Core\Enums\ParticipantDesignationEnum;
use Modules\Core\Core\Enums\ParticipantGenderEnum;
use Modules\Core\Core\Enums\ParticipantReligionEnum;
use Modules\Core\Core\Enums\ParticipantCommunityEnum;

class Create
{
	use AsAction;

	public function handle()
    {
		return view('profile::participant.create')->with([
			'designations' 			=> ParticipantDesignationEnum::asArray(),
			'genders' 				=> ParticipantGenderEnum::asArray(),
			'religions' 			=> ParticipantReligionEnum::asArray(),
			'communities' 			=> ParticipantCommunityEnum::asArray(),
			'active_profiles' 		=> Auth::user()->activeProfiles()->pluck('name', 'id')->toArray(),
		]);
    }
}