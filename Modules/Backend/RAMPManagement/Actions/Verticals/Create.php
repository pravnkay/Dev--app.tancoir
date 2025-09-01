<?php

namespace Modules\Backend\RAMPManagement\Actions\Verticals;

use Lorisleiva\Actions\Concerns\AsAction;

class Create
{
	use AsAction;

	public function handle()
	{
		return view('rampmanagement::verticals.create');
	}
}