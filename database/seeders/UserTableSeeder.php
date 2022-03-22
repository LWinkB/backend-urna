<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Luis Fernando',
            'email' => 'teste@gmail.com',
            'password' => Hash::make('123456'),
        ]);

    }
}
