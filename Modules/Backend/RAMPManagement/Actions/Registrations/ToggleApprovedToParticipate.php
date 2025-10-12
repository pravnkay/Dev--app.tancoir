<?php

namespace Modules\Backend\RAMPManagement\Actions\Registrations;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Registration;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ToggleApprovedToParticipate
{
	use AsAction;

	public function handle(Registration $registration)
    {
		$event = $registration->event()->select(['id', 'participant_count'])->first();

		if (! $event) {
			notify('Unable to locate the associated event for this registration.', ['status'=> 'destructive', 'icon' => 'circle-x']);
			return redirect()->back();
		}

		$shouldApprove = !$registration->is_approved_to_participate;
		$participantLimit = (int) ($event->participant_count ?? 0);

		try {

			DB::transaction(function () use ($registration, $event, $shouldApprove, $participantLimit) {

				if ($shouldApprove) {
					$approvedCount = Registration::where('event_id', $event->id)
						->where('is_approved_to_participate', true)
						->lockForUpdate()
						->count();

					if ($participantLimit > 0 && $approvedCount >= $participantLimit) {
						throw new RuntimeException('participant_limit_reached');
					}
				}

				$registration->update([
					'is_approved_to_participate' => $shouldApprove,
				]);

				if ($shouldApprove) {
					$registration->participation()->firstOrCreate([]);
				} else {
					$registration->participation()->delete();
				}

			}, 3);

		} catch (RuntimeException $exception) {

			if ($exception->getMessage() === 'participant_limit_reached') {
				notify('Participation slots filled!', ['status'=> 'destructive', 'icon' => 'circle-x']);
				return redirect()->back();
			}

			report($exception);
			notify('Unable to update participation approval.', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();

		} catch (\Throwable $exception) {

			report($exception);
			notify('Unable to update participation approval.', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();

		}

		$message = $shouldApprove ? 'Participant approved to attend!' : 'Participant approval revoked.';
		$icon = $shouldApprove ? 'circle-check-big' : 'circle-x';
		notify($message, ['icon' => $icon]);

		return redirect()->back();
	}

}
