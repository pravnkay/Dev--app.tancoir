<?php

namespace Modules\Backend\Dashboard\Actions\Bulk\Importer;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\Enterprise;
use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Backend\RAMPManagement\Entities\Programme;
use Modules\Backend\RAMPManagement\Entities\Vertical;

class Create
{
	use AsAction;

	public function handle($snake_cased_model)
	{
		$model_classes 		= [
			'verticals' 	=> Vertical::class,
			'programmes' 	=> Programme::class,
			'events' 		=> Event::class,
			'enterprises'	=> Enterprise::class
		];

		$studly = \Illuminate\Support\Str::studly(\Illuminate\Support\Str::singular($snake_cased_model));

        return view('dashboard::bulk.importer.create')->with([
			'model_class' 	=> $model_classes[$snake_cased_model],
			'model' 		=> $snake_cased_model,
			'studly' 		=> $studly,
		]);
	}
}