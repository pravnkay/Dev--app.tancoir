<?php

namespace Modules\Registry\Ramp\Actions\Apply;

use Lorisleiva\Actions\Concerns\AsAction;

class Index
{
	use AsAction;

	public function handle()
    {
		return view('ramp::apply.index');
    }
}