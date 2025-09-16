<?php

namespace Modules\Backend\RAMPManagement\Actions\Registrations;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\DataTables\RegistrationsDatatable;
use Modules\Backend\RAMPManagement\Entities\Event;

class Index
{
	use AsAction;

	public function handle(RegistrationsDatatable $datatable, ?Event $filtered_event = null)
    {
		clock($filtered_event);

		if($filtered_event) {
			clock('true');
		} else {
			clock('false');
		}
		
		$all_events = Event::all();

		return $datatable->with('filtered_event', $filtered_event)->render('rampmanagement::registrations.index', [
			'model' => 'Modules\\Backend\\RAMPManagement\\Entities\\EventRegistration',
			'all_events' => $all_events,
			'filtered_event' => $filtered_event
		]);
    }
}