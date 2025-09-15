<?php

namespace Modules\Backend\RAMPManagement\Actions\Enterprises;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Enterprise;

class ToggleValidStatus
{
	use AsAction;

	public function handle(Enterprise $enterprise)
    {
        $enterprise->update([
			'is_a_valid_enterprise' => !$enterprise->is_a_valid_enterprise
		]);
		notify('Enterprise valid status changed!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.rampmanagement.enterprises.index');
    }
}