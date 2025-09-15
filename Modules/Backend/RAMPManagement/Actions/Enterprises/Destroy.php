<?php

namespace Modules\Backend\RAMPManagement\Actions\Enterprises;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Enterprise;

class Destroy
{
	use AsAction;

	public function handle(Enterprise $enterprise)
    {
        $enterprise->delete();
		notify('Enterprise Deleted!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.rampmanagement.enterprises.index');
    }
}