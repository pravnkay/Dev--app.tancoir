<?php

namespace Modules\Registry\Profile\Actions\Profiles;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Core\Core\Enums\ProfileTypeEnum;

class Create
{
	use AsAction;

	public function handle()
    {
		$profile_types = ProfileTypeEnum::asArray();

		return view('profile::profile.create')->with([
			'profile_types'			=> $profile_types,
			'user'					=> Auth::user(),
		]);
    }
}