<?php

namespace Modules\Backend\RAMPManagement\Actions\Registrations;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Registration;

class ToggleEligibleToParticipate
{
	use AsAction;

	public function handle(Registration $registration)
    {
		$this_registration = $registration;
		$this_registrations_enterprise = $this_registration->enterprise()->first();
		$this_registrations_programme_id = $this_registration->event->programme->id;

		$enterprise_of_this_registration_is_valid = $this_registrations_enterprise->is_a_valid_enterprise;

		$this_registrations_enterprise_has_participated_in_same_programme = $this_registrations_enterprise->registrations()
		->where('is_approved_to_participate', true)
		->whereHas('event', function ($query) use ($this_registrations_programme_id, $this_registration) {
			$query->where('programme_id', $this_registrations_programme_id)
			->where('id', '!=', $this_registration->event_id);
		})
		->exists();

		$is_eligible_to_participate = false;

		if ($enterprise_of_this_registration_is_valid && !$this_registrations_enterprise_has_participated_in_same_programme) {
			$is_eligible_to_participate = true;
		}

		$registration->update([
			'is_eligible_to_participate' => $is_eligible_to_participate,
		]);
    }
}