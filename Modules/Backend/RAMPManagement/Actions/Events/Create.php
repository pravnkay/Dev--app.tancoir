<?php

namespace Modules\Backend\RAMPManagement\Actions\Events;

use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Programme;

class Create
{
	use AsAction;

	public function handle()
	{
		$programmes = Programme::has('vertical')->pluck('name', 'id')->toArray();		
		return view('rampmanagement::events.create')->with([
			'programmes' => $programmes
		]);
	}
}