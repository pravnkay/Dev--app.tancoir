<?php

namespace Modules\Core\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Auth\Entities\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Root',
            'email' => 'root@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Open8d@16'),
            'remember_token' => \Str::random(10),
        ])->assignRole(['root', 'admin', 'user']);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Open8d@16'),
            'remember_token' => \Str::random(10),
        ])->assignRole(['admin']);				
    }
}
