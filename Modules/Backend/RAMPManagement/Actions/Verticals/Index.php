<?php

namespace Modules\Backend\RAMPManegement\Actions\Verticals;

use Lorisleiva\Actions\Concerns\AsAction;

class Index
{
	use AsAction;

	public function handle()
    {
		return view('rampmanagement::verticals.index');
    }
}