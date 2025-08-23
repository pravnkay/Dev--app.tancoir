<?php

namespace Modules\Core\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		Role::create([
			'name' => 'root',
		]);

		Role::create([
			'name' => 'admin',
		]);

		Role::create([
			'name' => 'user',
		]);
		
		$permission_collection = collect([

			'settings' => [

				'role'=> [
					'index',
					'create',
					'store',
					'show',
					'edit',
					'update',
					'destroy',
				],

				'user'=> [
					'index',
					'create',
					'store',
					'show',
					'edit',
					'update',
					'destroy',
				],

			]

		]);

		foreach($permission_collection as $module => $models) {

			Permission::create([
				'name' => 'index '.$module,
				'module' => $module,
				'model' => $module,
			]);

			foreach($models as $model => $permissions) {

				foreach ($permissions as $permission) {

					Permission::create([
						'name' => $permission.' '.$model,
						'module' => $module,
						'model' => $model,
					]);

				}

			}

		}

    }
}
