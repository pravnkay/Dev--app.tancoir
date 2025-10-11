<?php

namespace Modules\Backend\RAMPManagement\Actions\Participations;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\DataTables\ParticipationsDatatable;
use Modules\Backend\RAMPManagement\Entities\Event;

class Index
{
	use AsAction;

	public function handle(ParticipationsDatatable $datatable, ?Event $filtered_event = null)
    {		
		$all_events = Event::all();

		return $datatable->with('filtered_event', $filtered_event)->render('rampmanagement::participations.index', [
			'model' => 'Modules\\Backend\\RAMPManagement\\Entities\\Participation',
			'all_events' => $all_events,
			'filtered_event' => $filtered_event
		]);
    }
}