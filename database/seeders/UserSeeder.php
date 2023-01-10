<?php

namespace Database\Seeders;

use App\Classes\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'owner',
            'email' => 'owner@'.Str::lower(config('app.name')).'.com',
            'email_verified_at' => now(),
            'password' => 'owner',
            'permissions' => array_keys(Permission::all())
        ]);
        User::factory(5)->create();
    }
}
