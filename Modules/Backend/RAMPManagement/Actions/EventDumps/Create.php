<?php

namespace Modules\Backend\RAMPManagement\Actions\EventDumps;

use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Event;

class Create
{
	use AsAction;

	public function handle(Event $event)
	{
		return view('rampmanagement::event_dumps.create')->with([
			'event' => $event
		]);
	}
}
