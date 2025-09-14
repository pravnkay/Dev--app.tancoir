<?php

namespace Modules\Backend\RAMPManagement\Actions\EventDumps;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Event;

class Store
{
	use AsAction;

	public function handle(ActionRequest $request, Event $event)
	{
		// TODO: Implement event dump storage logic
		notify('Event Dump Created!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.rampmanagement.events.index');
	}

	public function rules()
    {
        return [
            'dump_data' => ['required', 'string'],
        ];
    }
}
