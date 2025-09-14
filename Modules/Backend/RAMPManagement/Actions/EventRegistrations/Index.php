<?php

namespace Modules\Backend\RAMPManagement\Actions\EventRegistrations;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\DataTables\EventRegistrationsDatatable;
use Modules\Backend\RAMPManagement\Entities\Event;

class Index
{
	use AsAction;

	public function handle(EventRegistrationsDatatable $datatable, Event $event)
    {
		return $datatable->with('event_id', $event->id)->render('rampmanagement::event_registrations.index', [
			'model' => 'Modules\\Backend\\RAMPManagement\\Entities\\EventRegistration',
			'event' => $event
		]);
    }
}