<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $user = User::create([
            'name' => 'jhonny',
            'email' => 'jhonny@admin.com',
            'username' => 'admin',
            'password' => bcrypt('1q2w3e4r'),
        ]);

        $user->assignRole('Admin');
    }
}
