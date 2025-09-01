<?php

namespace Modules\Backend\RAMPManagement\Actions\Programmes;

use Illuminate\Validation\Rule;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Programme;
use Modules\Core\Core\Enums\ProgrammeSchemeEnum;

class Update
{
	use AsAction;

	public function handle(ActionRequest $request, Programme $programme)
    {
        $programme->update($request->validated());
		notify('Programme Updated!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.rampmanagement.programmes.index');
    }

	public function rules(ActionRequest $request)
    {
        return [
            'name' 			=> ['required', 'string', 'max:25', Rule::unique('ramp_programmes')->ignore($request->route('programme'))],
			'scheme'		=> ['required', Rule::enum(ProgrammeSchemeEnum::class)],
            'vertical_id' 	=> ['required', Rule::exists('ramp_verticals', 'id')],
        ];
    }
}