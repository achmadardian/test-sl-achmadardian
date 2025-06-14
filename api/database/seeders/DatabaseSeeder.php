<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => env('ADMIN_EMAIL'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);

        $positions = [
            'Manager',
            'Backend Developer',
            'Frontend Developer',
            'Accountant',
            'Security',
            'Marketing'
        ];

        foreach ($positions as $position) {
            Position::create([
                'name' => $position,
            ]);
        }

        $employees = [
            [
                'name' => 'Fulan',
                'email' => 'fulan@gmail.com',
                'hired_at' => '2015-01-15 09:00:00',
                'position_id' => 1,
            ],
            [
                'name' => 'Achmad',
                'email' => 'achmad@gmail.com',
                'hired_at' => '2024-01-01 09:00:00',
                'position_id' => 2,
            ],
            [
                'name' => 'Ardian',
                'email' => 'ardian@gmail.com',
                'hired_at' => '2025-01-15 09:00:00',
                'position_id' => 3,
            ],
            [
                'name' => 'Lestiowo',
                'email' => 'lestiowo@gmail.com',
                'hired_at' => '2025-01-06 09:00:00',
                'position_id' => 4,
            ],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
