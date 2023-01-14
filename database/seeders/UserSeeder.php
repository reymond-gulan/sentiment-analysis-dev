<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'admin@admin.com';

        $user = User::where('email', $email)->first();
        
        if(empty($user)) {
            User::create([
                'name' => 'Super Administrator',
                'email' => $email,
                'password' => bcrypt('admin123'),
                'user_type' => User::TYPE_SUPER_ADMIN,
                'campus_id' => 1
            ]);
        }
    }
}
