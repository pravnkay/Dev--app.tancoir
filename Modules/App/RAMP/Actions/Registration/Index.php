<?php

namespace Modules\App\RAMP\Actions\Registration;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\App\RAMP\DataTables\RegistrationsDatatable;
use Modules\Backend\RAMPManagement\Entities\Event;

class Index
{
	use AsAction;

	public function handle(RegistrationsDatatable $datatable, ?Event $filtered_event = null)
    {
		$all_events = Event::all();

		return $datatable->with('filtered_event', $filtered_event)->render('ramp::registration.index', [
			'model' => 'Modules\\Backend\\RAMPManagement\\Entities\\Registration',
			'all_events' => $all_events,
			'filtered_event' => $filtered_event
		]);
    }
}