<?php

namespace Modules\App\App\Actions;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class Index
{
	use AsAction;

	public function handle()
    {
		return view('app::app.index', [
			'user'	=> Auth::user(),
		]);
    }
}