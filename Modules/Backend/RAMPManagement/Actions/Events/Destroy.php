<?php

namespace Modules\Backend\RAMPManagement\Actions\Events;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Event;

class Destroy
{
	use AsAction;

	public function handle(Event $event)
    {
        $event->delete();
		notify('Event Deleted!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.rampmanagement.events.index');
    }
}