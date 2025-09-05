<?php

namespace Modules\App\Profile\Actions\Profiles;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\App\Profile\Entities\Profile;
use Modules\Core\Core\Enums\ProfileStatusEnum;

class Activate
{
	use AsAction;

	public function handle(Profile $profile)
    {
		if ($profile->status !== ProfileStatusEnum::APPROVED) {
			notify('Profile not approved! Submit for approval.', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();
		}

		if($profile->is_active) {
			$profile->update(['is_active' => false]);
			notify('Profile Deactivated!', ['icon' => 'circle-check-big']);
		} else {
			$profile->update(['is_active' => true]);
			notify('Profile Activated!', ['icon' => 'circle-check-big']);
		}

		return redirect()->back();

    }
}