<?php

namespace Modules\Backend\RAMPManagement\Actions\Verticals;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\DataTables\VerticalsDatatable;

class Index
{
	use AsAction;

	public function handle(VerticalsDatatable $datatable)
    {
		return $datatable->render('rampmanagement::verticals.index', [
			'model' => 'Modules\\Backend\\RAMPManagement\\Entities\\Vertical'
		]);
    }
}