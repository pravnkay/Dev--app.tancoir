<?php

namespace Modules\Backend\Dashboard\Actions\Bulk\Destroyer;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class Destroy
{
	use AsAction;

	public function handle(ActionRequest $request)
    {
		$validated = $request->validated();
		$count = 0;

		clock($validated);

		try {
			\DB::transaction(function () use (&$count, $validated) {

				$ids = array_values(array_unique($validated['ids']));

				$modelClass = $validated['model'];
				$model = new $modelClass;

				// Lock rows so they can’t change mid-delete
				$models = $model::whereKey($ids)->lockForUpdate()->get();
	
				// Fail the whole operation if any id is missing
				$found = $models->modelKeys();
				$missing  = array_values(array_diff($ids, $found));

				if (!empty($missing)) {
					throw new \RuntimeException('Some records were not found: '.implode(', ', $missing));
				}			

				foreach ($models as $model) {	
					$deleted = $model->delete();	
					if ($deleted === false) {
						throw new \RuntimeException("Delete failed for ID {$model->getKey()}");
					}
					$count++;
				}

			}, 3);

			notify($count.' Records Deleted!', ['icon' => 'circle-check-big']);
	
			return redirect()->back();

		} catch (\Throwable $e) {

			clock($e->getMessage());
			notify('DB Error. Contact Admin!', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();

		}

    }

	public function rules()
    {
        return [
            'ids'   => ['required','array','min:1'],
        	'ids.*' => ['integer'],
			'model' => ['required', 'string']
        ];
    }
}