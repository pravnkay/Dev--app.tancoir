<?php

namespace Modules\App\Profile\Actions\Participants;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\App\Profile\DataTables\ParticipantsDatatable;

class Index
{
	use AsAction;

	public function handle(ParticipantsDatatable $datatable)
    {
		return $datatable->render('profile::participant.index', [
			//
		]);
    }
}