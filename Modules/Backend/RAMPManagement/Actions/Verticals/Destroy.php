<?php

namespace Modules\Backend\RAMPManagement\Actions\Verticals;

use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Vertical;

class Destroy
{
	use AsAction;

	public function handle(Vertical $vertical)
    {
        $vertical->delete();
		notify('Vertical Deleted!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.rampmanagement.verticals.index');
    }
}