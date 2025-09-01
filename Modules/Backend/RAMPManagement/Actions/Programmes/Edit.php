<?php

namespace Modules\Backend\RAMPManagement\Actions\Programmes;

use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Programme;
use Modules\Backend\RAMPManagement\Entities\Vertical;
use Modules\Core\Core\Enums\ProgrammeSchemeEnum;

class Edit
{
	use AsAction;

	public function handle(Programme $programme)
    {
		$verticals 	= Vertical::all()->pluck('name', 'id')->toArray();
		$schemes 	= ProgrammeSchemeEnum::asArray();

        return view('rampmanagement::programmes.edit')->with([
			'programme'	=> $programme,
			'verticals'	=> $verticals,
			'schemes'	=> $schemes,
		]);
    }
}