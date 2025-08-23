<?php

namespace Modules\Registry\Profile\Actions\Profiles;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\Core\Core\Enums\ProfileTypeEnum;

class Activate
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

		if ($profile->status !== ProfileStatusEnum::APPROVED) {
			notify('Profile not approved! Submit for approval.', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();
		}

		$user->active_profile_id = $profile->id;
		$user->active_profile_type = $profile->getMorphClass();
		$user->save();

		notify('Profile Activated!', ['icon' => 'circle-check-big']);
		return redirect()->back();

    }
}