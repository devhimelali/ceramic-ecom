<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Alex Johnson',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'Maria Lopez',
                'email' => 'user@gmail.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'Ethan Carter',
                'email' => 'superuser@gmail.com',
                'password' => bcrypt('password')
            ]
        ];

        foreach ($users as $user) {
            $createUser = User::create($user);
            if ($user['email'] == 'admin@gmail.com') {
                $createUser->assignRole('admin');
            } elseif ($user['email'] == 'user@gmail.com') {
                $createUser->assignRole('user');
            } elseif ($user['email'] == 'superuser@gmail.com') {
                $createUser->assignRole('super user');
            }
        }
    }
}
