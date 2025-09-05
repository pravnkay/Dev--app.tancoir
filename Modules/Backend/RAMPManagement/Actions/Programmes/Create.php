<?php

namespace Modules\Backend\RAMPManagement\Actions\Programmes;

use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Vertical;
use Modules\Core\Core\Enums\ProgrammeSchemeEnum;

class Create
{
	use AsAction;

	public function handle()
	{
		$verticals = Vertical::all()->pluck('name', 'id')->toArray();
		$schemes = ProgrammeSchemeEnum::asArray();

		return view('rampmanagement::programmes.create')->with([
			'verticals' => $verticals,
			'schemes' => $schemes,
		]);
	}
}