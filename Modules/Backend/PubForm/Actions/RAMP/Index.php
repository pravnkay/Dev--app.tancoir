<?php

namespace Modules\Backend\PubForm\Actions\RAMP;

use Lorisleiva\Actions\Concerns\AsAction;

class Index
{
	use AsAction;

	public function handle()
    {
		return view('pubform::ramp.index');
    }
}