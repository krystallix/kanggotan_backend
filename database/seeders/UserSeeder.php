<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sa = User::Create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'phone' => '0000',
            'password' => Hash::make('superadmin')
        ]);
        $sa->assignRole('Super Admin');
    }
}
