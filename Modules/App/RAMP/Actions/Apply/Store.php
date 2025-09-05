<?php

namespace Modules\App\RAMP\Actions\Apply;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class Store
{
	use AsAction;

	public function handle(ActionRequest $request)
	{
		$validated = $request->validated();

		try {

			\DB::transaction(function () use ($validated, &$profile) {

				//

			}, 3);	

		} catch (\Throwable $e) {

			clock($e->getMessage());
			notify('DB Error. Contact Admin!', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();

		}	

		notify('Applied successfully!', ['icon' => 'circle-check-big']);
		return redirect()->route('app.ramp.apply.index');

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
			//
        ];
    }
}