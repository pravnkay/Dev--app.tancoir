<?php

namespace Modules\Backend\RAMPManagement\Actions\Programmes;

use Illuminate\Validation\Rule;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Programme;
use Modules\Core\Core\Enums\ProgrammeSchemeEnum;

class Store
{
	use AsAction;

	public function handle(ActionRequest $request)
	{
		Programme::create($request->validated());
		notify('Programme Created!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.rampmanagement.programmes.index');
	}

	public function rules()
    {
        return [
            'name' 			=> ['required', 'string', 'max:25', Rule::unique('ramp_programmes', 'name')],
			'scheme'		=> ['required', Rule::enum(ProgrammeSchemeEnum::class)],
            'vertical_id' 	=> ['required', Rule::exists('ramp_verticals', 'id')],
        ];
    }
}