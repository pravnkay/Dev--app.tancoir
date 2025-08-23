<?php

namespace Modules\Registry\Registry\Actions;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Core\Core\Enums\ProfileTypeEnum;

class Index
{
	use AsAction;

	public function handle()
    {
		$profiles = Auth::user()->allProfiles()->toArray();
		$profile_types = ProfileTypeEnum::asArray();

		return view('registry::registry.index', [
			'profile_types'			=> $profile_types,
			'profiles'				=> $profiles,
			'user'					=> Auth::user(),
		]);
    }
}