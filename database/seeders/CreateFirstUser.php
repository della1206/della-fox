<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data user pertama (admin)
        $admin['name']     = 'Admin';
        $admin['email']    = 'gatot@pcr.ac.id';
        $admin['password'] = Hash::make('gatotkaca');

        User::create($admin);

        // Data user tambahan (14 user)
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Robert Johnson',
                'email' => 'robert.johnson@example.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@example.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david.wilson@example.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Lisa Brown',
                'email' => 'lisa.brown@example.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Michael Davis',
                'email' => 'michael.davis@example.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Sarah Miller',
                'email' => 'sarah.miller@example.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'James Taylor',
                'email' => 'james.taylor@example.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Emily Anderson',
                'email' => 'emily.anderson@example.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Daniel Thomas',
                'email' => 'daniel.thomas@example.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Jennifer Lee',
                'email' => 'jennifer.lee@example.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Christopher White',
                'email' => 'christopher.white@example.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Amanda Harris',
                'email' => 'amanda.harris@example.com',
                'password' => Hash::make('password123')
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}