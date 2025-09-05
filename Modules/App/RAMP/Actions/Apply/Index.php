<?php

namespace Modules\App\RAMP\Actions\Apply;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Event;

class Index
{
	use AsAction;

	public function handle()
    {
		$events = Event::all();
		return view('ramp::apply.index')->with([
			'events' => $events
		]);
    }
}