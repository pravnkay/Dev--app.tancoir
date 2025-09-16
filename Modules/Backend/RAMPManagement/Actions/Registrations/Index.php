<?php

namespace Modules\Backend\RAMPManagement\Actions\Registrations;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\DataTables\RegistrationsDatatable;

class Index
{
	use AsAction;

	public function handle(RegistrationsDatatable $datatable)
    {
		return $datatable->render('rampmanagement::registrations.index', [
			'model' => 'Modules\\Backend\\RAMPManagement\\Entities\\EventRegistration'
		]);
    }
}