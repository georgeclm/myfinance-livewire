<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PowerUserSeeder extends Seeder
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
            'email' => 'admin@example.com',
            'password' => '123456'
        ]);
    }
}
