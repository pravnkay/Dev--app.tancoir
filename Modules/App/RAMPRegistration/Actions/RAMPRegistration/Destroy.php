<?php

namespace Modules\App\RAMPRegistration\Actions\RAMPRegistration;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Registration;

class Destroy
{
	use AsAction;

	public function handle(Registration $registration)
    {		
		# Observer - Deleted		
		$registration->delete();
		notify('Registration Record Deleted!', ['icon' => 'circle-check-big']);
		return redirect()->route('app.rampregistration.index');
    }
}