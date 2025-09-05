<?php

namespace Modules\App\Profile\Actions\Profiles;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\App\Profile\Entities\Profile;
use Modules\Core\Core\Enums\DistrictEnum;

class Edit
{
	use AsAction;

	public function handle(Profile $profile)
    {
		$user = Auth::user();

		$viewName = "profile::profile.edit.{$profile->type->value}";

		return view($viewName)->with([
			'user' 			=> $user,
			'profile' 		=> $profile,
			'profile_data'	=> $profile->profile_data,
			'districts'		=> DistrictEnum::asArray(),
		]);

    }
}