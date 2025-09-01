<?php

namespace Modules\Backend\RAMPManagement\Actions\Verticals;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Vertical;

use Modules\Core\Core\Rules\SignedDecimal;

class Update
{
	use AsAction;

	public function handle(ActionRequest $request, Vertical $vertical)
    {
        $vertical->update($request->validated());
		notify('Vertical Updated!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.rampmanagement.verticals.index');
    }

	public function prepareForValidation(ActionRequest $request)
	{
		$input = array_filter($request->all(), function($val) { 
			return ($val || is_numeric($val));
		});

		$request->replace($input);
	}

	public function rules()
    {
        return [
            'name' 				=> ['required', 'string', 'max:25'],
            'allocated_funds' 	=> ['required', new SignedDecimal],
            'utilised_funds' 	=> ['required', new SignedDecimal],
            'remaining_funds' 	=> ['required', new SignedDecimal],
        ];
    }
}