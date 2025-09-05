<?php

namespace Modules\Backend\Moderation\Actions\Profiles;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\Moderation\DataTables\ProfilesDatatable;

class Index
{
	use AsAction;

	public function handle(ProfilesDatatable $datatable)
    {
		return $datatable->render('moderation::profile.index');
    }
}