<?php

namespace Modules\Backend\RAMPManagement\Actions\Enterprises;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\DataTables\EnterprisesDatatable;

class Index
{
	use AsAction;

	public function handle(EnterprisesDatatable $datatable)
    {
		return $datatable->render('rampmanagement::enterprises.index', [
			'model' => 'Modules\\Backend\\RAMPManagement\\Entities\\Enterprises'
		]);
    }
}