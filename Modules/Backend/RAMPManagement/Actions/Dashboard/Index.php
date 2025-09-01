<?php

namespace Modules\Backend\RAMPManegement\Actions\Dashboard;

use Lorisleiva\Actions\Concerns\AsAction;

class Index
{
	use AsAction;

	public function handle()
    {
		return view('rampmanagement::dashboard.index');
    }
}