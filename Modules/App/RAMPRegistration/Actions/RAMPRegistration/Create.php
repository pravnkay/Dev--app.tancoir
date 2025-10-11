<?php

namespace Modules\App\RAMPRegistration\Actions\RAMPRegistration;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Core\Core\Enums\ProfileTypeEnum;

class Create
{
	use AsAction;

	public function handle()
    {
		$profiles = Auth::user()->allProfiles()->toArray();
		$profile_types = ProfileTypeEnum::asArray();

		$registration_open_event_list = Event::where('is_registration_open', true)
		->orderBy('date')
		->get();

		return view('rampregistration::rampregistration.create')->with([
			'profile_types'						=> $profile_types,
			'profiles'							=> $profiles,
			'user'								=> Auth::user(),
			'approved_profile_list'				=> Auth::user()->allApprovedProfiles(),
			'participant_list'					=> Auth::user()->allParticipants(),
			'registration_open_event_list' 		=> $registration_open_event_list
		]);
    }
}