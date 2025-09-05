<?php

namespace Modules\App\Profile\Actions\Profiles;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\App\Profile\Entities\Profile;

class Destroy
{
	use AsAction;

	public function handle(Profile $profile)
    {
		$profile->delete();
		notify('Profile Deleted!', ['icon' => 'circle-check-big']);
		return redirect()->back();
    }
}