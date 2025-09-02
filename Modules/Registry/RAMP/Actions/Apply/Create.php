<?php

namespace Modules\Registry\RAMP\Actions\Apply;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Event;

class Create
{
	use AsAction;

	public function handle(Event $event)
    {
		return view('ramp::apply.create')->with([
			'event' => $event
		]);
    }
}