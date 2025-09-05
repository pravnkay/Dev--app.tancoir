<?php

namespace Modules\Backend\RAMPManagement\Actions\Events;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Backend\RAMPManagement\Entities\Programme;

class Edit
{
	use AsAction;

	public function handle(Event $event)
    {
		$programmes = Programme::has('vertical')->pluck('name', 'id')->toArray();
        return view('rampmanagement::events.edit')->with([
			'event' => $event,
			'programmes' => $programmes
		]);
    }
}