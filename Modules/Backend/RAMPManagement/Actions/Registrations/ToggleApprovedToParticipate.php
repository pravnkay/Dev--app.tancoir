<?php

namespace Modules\Backend\RAMPManagement\Actions\Registrations;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Registration;

class ToggleApprovedToParticipate
{
	use AsAction;

	public function handle(Registration $registration)
    {
		$registration->update([
			'is_approved_to_participate' => !$registration->is_approved_to_participate
		]);
		notify('Registration is now participating!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.rampmanagement.registrations.index');
    }
}