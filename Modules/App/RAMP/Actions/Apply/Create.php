<?php

namespace Modules\App\RAMP\Actions\Apply;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Core\Core\Enums\ParticipantCommunityEnum;
use Modules\Core\Core\Enums\ParticipantDesignationEnum;
use Modules\Core\Core\Enums\ParticipantGenderEnum;
use Modules\Core\Core\Enums\ParticipantReligionEnum;

class Create
{
	use AsAction;

	public function handle(Event $event)
    {
		$user = Auth::user();

		$participants = $user->participants()->with('profile')->get();
		$participants_grouped = $participants->groupBy('profile.id'); 

		return view('ramp::apply.create')->with([
			'event'						=> $event,
			'genders' 					=> ParticipantGenderEnum::asArray(),
			'designations' 				=> ParticipantDesignationEnum::asArray(),
			'religions' 				=> ParticipantReligionEnum::asArray(),
			'communities' 				=> ParticipantCommunityEnum::asArray(),
			'active_profiles' 			=> Auth::user()->activeProfiles()->pluck('name', 'id')->toArray(),
			'participants_grouped' 		=> $participants_grouped,
		]);
    }
}