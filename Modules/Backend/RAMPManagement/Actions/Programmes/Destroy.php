<?php

namespace Modules\Backend\RAMPManagement\Actions\Programmes;

use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Programme;

class Destroy
{
	use AsAction;

	public function handle(Programme $programme)
    {
        $programme->delete();
		notify('Programme Deleted!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.rampmanagement.programmes.index');
    }
}