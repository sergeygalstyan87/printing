<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '123456789',
            'password' => bcrypt('Yans2021'),
        ]);

        User::create([
            'name' => 'Test',
            'email' => 'customer@yansprint.com',
            'phone' => '123456789',
            'password' => bcrypt('Yans2021'),
        ]);
    }
}
