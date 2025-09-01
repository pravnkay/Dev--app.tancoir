<?php

namespace Modules\Backend\Moderation\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
	protected string $moduleName = 'Moderation';

    protected string $moduleNameLower = 'moderation';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
		$path = module_path($this->moduleName, 'Routes');
		$route_files = array_diff(scandir($path, 1), array('.', '..', '.gitkeep'));

		$routes_array = [];

		foreach ($route_files as $file) {
			array_push($routes_array, module_path($this->moduleName, ('Routes/'.$file)));
		}

		Route::middleware('web')
		->group(
			$routes_array
		);
	}
}
