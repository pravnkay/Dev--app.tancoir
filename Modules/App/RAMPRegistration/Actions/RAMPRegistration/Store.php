<?php

namespace Modules\App\RAMPRegistration\Actions\RAMPRegistration;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Backend\RAMPManagement\Entities\Participation;
use Modules\Backend\RAMPManagement\Entities\Registration;

class Store
{
	use AsAction;

	public function handle(ActionRequest $request)
	{
		$validated = $request->validated();

		try {

			\DB::transaction(function () use ($validated) {

				$event = Event::select(['id', 'participant_count'])->find($validated['event_id']);
				$registrations_count = Registration::where('event_id', $event->id)->count();
				$is_approved_to_participate = $registrations_count < (int) $event->participant_count;
				$registration_serial = $registrations_count + 1;

				$validated['is_approved_to_participate'] = $is_approved_to_participate;
				$validated['registration_serial'] = $registration_serial;
				$registration = Registration::create($validated);	
				
				if ($registration->is_approved_to_participate) {
					Participation::create([
						'registration_id' => $registration->id,
					]);
				}

			}, 3);	

		} catch (\Throwable $e) {

			clock($e->getMessage());
			notify('DB Error. Contact Admin!', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();

		}		

		notify('Registered successfully!', ['icon' => 'circle-check-big']);
		return redirect()->route('app.rampregistration.index');
	}

	public function prepareForValidation(ActionRequest $request)
	{
		$input = array_filter($request->all(), function($val) { 
			return ($val || is_numeric($val));
		});
		$input['user_id'] = Auth::id();		
		$request->replace($input);
	}

	public function rules()
    {
        return [
			'user_id' 			=> ['required', Rule::exists('acl_users', 'id')],
			'event_id' 			=> ['required', Rule::exists('ramp_events', 'id')],
			'profile_id' 		=> ['required', Rule::exists('profile_profiles', 'id')],
			'participant_id' 	=> ['required', Rule::exists('profile_participants', 'id')],
        ];
    }

}
