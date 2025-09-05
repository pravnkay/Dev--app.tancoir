<?php

namespace Modules\App\App\Actions;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class Index
{
	use AsAction;

	public function handle()
    {
		$user = Auth::user();
		$all_profiles = $user->allProfiles();
		$active_profiles = $user->activeProfiles();

		return view('app::app.index', [
			'user'	=> $user,
			'all_profiles'	=> $all_profiles,
			'active_profiles'	=> $active_profiles,
		]);
    }
}