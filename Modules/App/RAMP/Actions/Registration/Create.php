<?php

namespace Modules\App\RAMP\Actions\Registration;

use Illuminate\Support\Facades\Auth;

use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Event;

class Create
{
	use AsAction;

	public function handle()
    {
		$registration_open_event_list = Event::where('is_registration_open', true)
		->orderBy('date')
		->get();

		return view('ramp::registration.create')->with([
			'user'								=> Auth::user(),
			'approved_profile_list'				=> Auth::user()->allApprovedProfiles(),
			'participant_list'					=> Auth::user()->allParticipants(),
			'registration_open_event_list' 		=> $registration_open_event_list
		]);
    }
}