<?php

namespace Modules\Backend\Moderation\Actions\Profiles;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\Core\Core\Enums\ProfileTypeEnum;

class Edit
{
	use AsAction;

	public function handle(string $profile_type, int $profile_id)
    {

		// Validate profile type
		$profileEnum = ProfileTypeEnum::tryFrom($profile_type);
		if (!$profileEnum) {
			notify('Invalid profile type!', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();
		}

		$modelClass = $profileEnum->classDefinition();
		
		// Find profile
		$profile = $modelClass::where('id', $profile_id)->first();

		if (!$profile) {
			notify('Profile not found!', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();
		}

		$viewName = "moderation::profile.edit.{$profile_type}";

		clock($profile);

		return view($viewName)->with([
			'profile' 		=> $profile,
			'profile_type'	=> $profile_type,
			'statuses'		=> ProfileStatusEnum::asArray(),
		]);
    }
}