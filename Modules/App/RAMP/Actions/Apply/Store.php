<?php

namespace Modules\App\RAMP\Actions\Apply;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\App\Profile\Entities\Participant;
use Modules\App\Profile\Entities\Profile;

use Modules\Backend\RAMPManagement\Actions\EventRegistrations\ProcessRegistration;

use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Backend\RAMPManagement\Entities\EventRegistration;

use Modules\Core\Core\Rules\NotParticipatedInProgramme;

class Store
{
	use AsAction;

	public function handle(ActionRequest $request, Event $event)
	{
		$validated = $request->validated();

		try {

			DB::transaction(function () use ($validated, $event) {

				$registration = EventRegistration::create([
					'event_id' => $event->id,
					'user_id' => Auth::id(),
					'profile_id' => $validated['profile_id'],
					'participant_id' => $validated['participant_id'],
				]);

				$response = ProcessRegistration::run($registration);

				notify($response['message'], ['icon' => $response['icon']]);

			}, 3);	

		} catch (\Throwable $e) {

			clock($e->getMessage());
			notify('DB Error. Contact Admin!', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();

		}	

		return redirect()->route('app.ramp.apply.index');

	}


	public function prepareForValidation(ActionRequest $request)
	{
		$input = array_filter($request->all(), function($val) { 
			return ($val || is_numeric($val));
		});
		
		$request->replace($input);

	}

	public function rules(ActionRequest $request)
    {
		$event = $request->route('event');
        return [
			'profile_id' => [
				'required', 
				Rule::exists(Profile::class, 'id'), 
				new NotParticipatedInProgramme($event->id, $request->input('profile_id')),
				Rule::unique('ramp_event_registrations')->where(function ($query) use ($event, $request) {
					return $query->where('event_id', $event->id)
								->where('profile_id', $request->input('profile_id'));
				}),
			],
			'participant_id' => [
				'required', 
				Rule::exists(Participant::class, 'id'),
				Rule::unique('ramp_event_registrations')->where(function ($query) use ($event, $request) {
					return $query->where('event_id', $event->id)
								->where('profile_id', $request->input('profile_id'))
								->where('participant_id', $request->input('participant_id'));
				}),
			],
        ];
    }

	public function getValidationMessages(): array
    {
        return [
            'profile_id.unique' => 'You have already applied for this event!',
            'participant_id.unique' => 'You have already applied for this event!',
        ];
    }
}