<?php

namespace Modules\Registry\Profile\Actions\Profiles;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Core\Core\Enums\ProfileTypeEnum;
use Modules\Registry\Profile\DataTables\ProfileablesDatatable;

class Index
{
	use AsAction;

	public function handle(ProfileablesDatatable $datatable)
    {
		$profiles = Auth::user()->allProfiles()->toArray();
		$profile_types = ProfileTypeEnum::asArray();

		return $datatable->render('profile::profile.index', [
			'profile_types'			=> $profile_types,
			'profiles'				=> $profiles,
			'user'					=> Auth::user(),
		]);
    }
}