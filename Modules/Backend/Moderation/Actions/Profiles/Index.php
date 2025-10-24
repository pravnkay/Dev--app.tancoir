<?php

namespace Modules\Backend\Moderation\Actions\Profiles;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\Moderation\DataTables\ProfilesDatatable;
use Modules\Core\Core\Enums\ProfileTypeEnum;
use Modules\Core\Core\Enums\ProfileStatusEnum;

class Index
{
	use AsAction;

	public function handle(ProfilesDatatable $datatable, $filtered_profile_status = 'all', $filtered_profile_type = 'all')
    {
		$profile_types = ProfileTypeEnum::asArray();
		$profile_statuses = ProfileStatusEnum::asArray();

		return $datatable->with([
			'filtered_profile_status' => $filtered_profile_status,
			'filtered_profile_type' => $filtered_profile_type,
		])->render('moderation::profile.index', [
			'all_profile_types' => $profile_types,
			'all_profile_statuses' => $profile_statuses,
			'filtered_profile_type' => $filtered_profile_type,
			'filtered_profile_status' => $filtered_profile_status,
		]);
    }
}
