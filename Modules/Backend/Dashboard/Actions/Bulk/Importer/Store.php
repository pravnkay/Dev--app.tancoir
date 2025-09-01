<?php

namespace Modules\Backend\Dashboard\Actions\Bulk\Importer;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\SimpleExcel\SimpleExcelReader;

class Store
{
	use AsAction;

	public function handle(ActionRequest $request)
    {
		$validated = $request->validated();

		\DB::beginTransaction();

		try {

			$redirect_route = (new $validated['model'])->uploader_redirect;

			$file = $validated['file'];
			$ext = strtolower($file->getClientOriginalExtension() ?: $file->extension());
			$type = in_array($ext, ['xlsx','csv'], true) ? $ext : 'xlsx';

			// read directly from PHP’s tmp upload without persisting
			$rows = SimpleExcelReader::create($file->getRealPath(), $type)->getRows();

			$created_models = 0;
			$modelClass = $validated['model'];

			$rows->each(function (array $row, int $index) use (&$created_models, $modelClass, $validated) {

				if(isset($validated['is_json'])) {
					$row['data'] = $row;
				}
				
				$model = new $modelClass;
				$model->fill($row);
				$model->save();

				$created_models++;

			});

			\DB::commit();
			notify($created_models.' Records Imported!', ['icon' => 'circle-check-big']);

		} catch (\Throwable $th) {

			clock($th);
			clock($th->getMessage());
			notify('DB Error. Contact Admin!', ['status'=> 'destructive', 'icon' => 'ban']);
			\DB::rollBack();

		}

		return redirect()->route($redirect_route);
    }

	public function prepareForValidation(ActionRequest $request)
	{
		$input = array_filter($request->all(), function($val) { 
			return ($val || is_numeric($val));
		});

		$input = $this->check_model_class_exists($input);
		$request->replace($input);

	}

    public function rules()
    {
		return [
			'file' 			=> ['required', 'file', 'mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'max:4096'],
			'studly' 		=> ['required', 'string'],
			'model' 		=> ['required', 'string'],
			'is_json'		=> ['sometimes', 'string']
		];
    }

	public function check_model_class_exists($input)
	{
		if(class_exists($input['model_class'])) {
			$input['model'] = $input['model_class'];
		}
        return $input;
	}
}