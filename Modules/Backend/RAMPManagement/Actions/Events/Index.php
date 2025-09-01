<?php

namespace Modules\Backend\RAMPManagement\Actions\Events;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\DataTables\EventsDatatable;

class Index
{
	use AsAction;

	public function handle(EventsDatatable $datatable)
    {
		return $datatable->render('rampmanagement::events.index', [
			'model' => 'Modules\\Backend\\RAMPManagement\\Entities\\Event'
		]);
    }
}