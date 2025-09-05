<?php

namespace Modules\Backend\Moderation\Actions\Profiles;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\App\Profile\Entities\Profile;
use Modules\Core\Core\Enums\ProfileStatusEnum;

class Edit
{
	use AsAction;

	public function handle(Profile $profile)
    {
		return view('moderation::profile.edit')->with([
			'profile' 		=> $profile,
			'statuses'		=> ProfileStatusEnum::asArray(),
		]);
    }
}