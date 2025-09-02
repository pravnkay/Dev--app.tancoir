<?php

namespace Modules\Core\Auth\Database\Seeders;

use Illuminate\Database\Seeder;

class AuthDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
			PermissionsSeeder::class,
			UsersSeeder::class
		]);
    }
}
