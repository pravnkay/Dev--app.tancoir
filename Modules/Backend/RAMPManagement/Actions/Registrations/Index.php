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
		$all_events = Event::all();

		$slot_summary = null;

		if ($filtered_event) {

			$filtered_event->loadCount([
				'registrations',
				'registrations as approved_registrations_count' => fn ($query) => $query->where('is_approved_to_participate', true),
			]);

			$slot_summary = [
				'total' => (int) ($filtered_event->participant_count ?? 0),
				'filled' => (int) $filtered_event->registrations_count,
				'approved' => (int) $filtered_event->approved_registrations_count,
			];
			
		}

		

		return $datatable->with('filtered_event', $filtered_event)->render('rampmanagement::registrations.index', [
			'model' => 'Modules\\Backend\\RAMPManagement\\Entities\\Registration',
			'all_events' => $all_events,
			'filtered_event' => $filtered_event,
			'slot_summary' => $slot_summary,
		]);
    }
}
