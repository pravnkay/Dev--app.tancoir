<?php

namespace Modules\Registry\Profile\Actions\Profiles;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Core\Core\Enums\DistrictEnum;
use Modules\Core\Core\Enums\ProfileTypeEnum;

class Edit
{
	use AsAction;

	public function handle(string $profile_type, int $profile_id)
    {
		$user = Auth::user();
    
		// Validate profile type
		$profileEnum = ProfileTypeEnum::tryFrom($profile_type);
		if (!$profileEnum) {
			notify('Invalid profile type!', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();
		}

		$modelClass = $profileEnum->classDefinition();
		
		// Find and ensure ownership
		$profile = $modelClass::where('id', $profile_id)
					->where('user_id', $user->id)
					->first();

		if (!$profile) {
			notify('Profile not found!', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();
		}

		$viewName = "profile::profile.edit.{$profile_type}";

		return view($viewName)->with([
			'user' 			=> $user,
			'profile' 		=> $profile,
			'profile_type'	=> $profile_type,
			'districts'		=> DistrictEnum::asArray(),
		]);

    }
}