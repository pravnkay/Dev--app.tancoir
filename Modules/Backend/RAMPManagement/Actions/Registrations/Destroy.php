<?php

namespace Modules\Backend\RAMPManagement\Actions\Registrations;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Registration;

class Destroy
{
	use AsAction;

	public function handle(Registration $registration)
    {
		$event_id = $registration->event_id;
        $registration->delete();
		notify('Registration Record Deleted!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.rampmanagement.registrations.index', ['filtered_event' => $event_id]);
    }
}