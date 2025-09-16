<?php

namespace Modules\Backend\RAMPManagement\Actions\Registrations;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Backend\RAMPManagement\Entities\Event;
use Spatie\SimpleExcel\SimpleExcelReader;

class StoreUpload
{
	use AsAction;

	public function handle(ActionRequest $request, Event $filtered_event)
	{
		$validated = $request->validated();

		try {

			\DB::transaction(function () use ($validated, &$filtered_event) {

				$file = $validated['file'];
				$ext = strtolower($file->getClientOriginalExtension() ?: $file->extension());
				$type = in_array($ext, ['xlsx','csv'], true) ? $ext : 'xlsx';

				// read directly from PHP’s tmp upload without persisting
				$rows = SimpleExcelReader::create($file->getRealPath(), $type)->getRows();

				$created_models = 0;

				$rows->each(function (array $row, int $index) use (&$created_models, &$filtered_event) {

					$filtered_event->registrations()->create([
						'registration_data' => $row
					]);

					$created_models++;

				});

				\DB::commit();
				notify($created_models.' Registrations created!', ['icon' => 'circle-check-big']);

			}, 3);	

		} catch (\Throwable $e) {

			clock($e->getMessage());
			notify('DB Error. Contact Admin!', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();

		}

		return redirect()->route('backend.rampmanagement.events.index');
    }

    public function rules()
    {
		return [
			'file' 		=> ['required', 'file', 'mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'max:4096'],
		];
    }
}
