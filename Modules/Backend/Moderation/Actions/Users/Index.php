<?php

namespace Modules\Backend\Moderation\Actions\Users;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\Moderation\DataTables\UsersDatatable;

class Index
{
	use AsAction;

	public function handle(UsersDatatable $datatable)
    {
		return $datatable->render('moderation::users.index');
    }
}