<?php

namespace Modules\App\Profile\Actions\Participants;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\App\Profile\Entities\Participant;

class Destroy
{
	use AsAction;

	public function handle(Participant $participant)
    {
		$participant->delete();
		notify('Participant Deleted!', ['icon' => 'circle-check-big']);
		return redirect()->back();
    }
}