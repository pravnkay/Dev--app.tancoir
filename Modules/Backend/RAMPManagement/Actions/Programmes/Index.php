<?php

namespace Modules\Backend\RAMPManagement\Actions\Programmes;

use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\DataTables\ProgrammesDatatable;

class Index
{
	use AsAction;

	public function handle(ProgrammesDatatable $datatable)
    {
		return $datatable->render('rampmanagement::programmes.index', [
			'model' => 'Modules\\Backend\\RAMPManagement\\Entities\\Programme'
		]);
    }
}