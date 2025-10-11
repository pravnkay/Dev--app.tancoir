<?php

namespace Modules\Backend\RAMPManagement\Actions\Enterprises;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Enterprise;

class ToggleValidStatus
{
	use AsAction;

	public function handle(Enterprise $enterprise)
    {
		# Observer - Updated
		$participations_exists = $enterprise->registrations()
		->where('is_approved_to_participate', true)
		->exists();

		if($participations_exists) {
			
			notify('There are valid participations!', ['status'=> 'destructive', 'icon' => 'circle-x']);

		} else {

			$enterprise->update([
				'is_a_valid_enterprise' => !$enterprise->is_a_valid_enterprise
			]);
	
			notify($enterprise->is_a_valid_enterprise ? 'Enterprise marked valid!' : 'Enterprise marked invalid.', ['icon' => $enterprise->is_a_valid_enterprise ? 'circle-check-big' : 'circle-x']);

		}

        
		return redirect()->route('backend.rampmanagement.enterprises.index');
    }
}