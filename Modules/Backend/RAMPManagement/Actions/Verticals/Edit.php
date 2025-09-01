<?php

namespace Modules\Backend\RAMPManagement\Actions\Verticals;

use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Vertical;

class Edit
{
	use AsAction;

	public function handle(Vertical $vertical)
    {
        return view('rampmanagement::verticals.edit')->with([
			'vertical' => $vertical
		]);
    }
}