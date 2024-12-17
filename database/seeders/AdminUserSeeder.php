<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Find the admin user by email
        $adminUser = User::where('email', 'admin@admin.com')->first();

        if ($adminUser) {
            $adminUser->role_id = 1;
            $adminUser->save();
        }
    }
}
