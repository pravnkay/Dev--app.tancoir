<?php

namespace Modules\Backend\RAMPManagement\Actions\EventRegistrations;

use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Event;

class Create
{
	use AsAction;

	public function handle(Event $event)
	{
		clock($event);
		return view('rampmanagement::event_registrations.create')->with([
			'event' => $event
		]);
	}
}
