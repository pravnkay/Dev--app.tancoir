<?php

namespace Modules\Backend\RAMPManagement\Actions\Registrations;

use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Event;

class Upload
{
	use AsAction;

	public function handle(Event $filtered_event)
	{
		return view('rampmanagement::registrations.upload')->with([
			'event' => $filtered_event
		]);
	}
}
