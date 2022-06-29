<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;
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
        $users = [
            [
                'name' => 'Admin', 
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123123'),
                'role' => 'admin'
            ],
            [
                'name' => 'User', 
                'email' => 'user@gmail.com',
                'password' => Hash::make('123123'),
                'role' => 'user'
            ]
        ];

        foreach($users as $value){
            User::create($value);
        }
    }
}
