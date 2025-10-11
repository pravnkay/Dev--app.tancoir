<?php

namespace Modules\Backend\RAMPManagement\Actions\Events;

use Illuminate\Validation\Rule;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Core\Core\Rules\UnsignedDecimal;

class Store
{
	use AsAction;

	public function handle(ActionRequest $request)
	{
		Event::create($request->validated());
		notify('Event Created!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.rampmanagement.events.index');
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
            'programme_id' 			=> ['required', Rule::exists('ramp_programmes', 'id')],
			'title' 				=> ['required', 'string'],
			'date' 					=> ['required', 'date'],
			'days' 					=> ['required', 'integer'],
			'cost' 					=> ['required', new UnsignedDecimal],
			'participant_count' 	=> ['required', 'integer'],
			'is_registration_open' 	=> ['required', 'boolean'],
        ];
    }
}