<?php

namespace Modules\Backend\RAMPManagement\Actions\EventRegistrations;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Backend\RAMPManagement\Entities\EventRegistration;

class Destroy
{
	use AsAction;

	public function handle(EventRegistration $event_registration)
    {
		$event_id = $event_registration->event_id;
        $event_registration->delete();
		notify('Registration Record Deleted!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.rampmanagement.events.registrations.index', ['event' => $event_id]);
    }
}