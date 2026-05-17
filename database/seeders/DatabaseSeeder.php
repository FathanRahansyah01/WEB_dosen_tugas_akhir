<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\StressResult;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@stressmonitor.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Dosen
        $dosen1 = User::create([
            'name' => 'Dr. Ahmad Fauzi',
            'nip' => '198503012010011001',
            'email' => 'ahmad@stressmonitor.com',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        $dosen2 = User::create([
            'name' => 'Dr. Siti Nurhaliza',
            'nip' => '199001152015042002',
            'email' => 'siti@stressmonitor.com',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        // Create Students for Dosen 1
        $students1 = [
            ['nama' => 'Budi Santoso', 'nim' => '2021001', 'email' => 'budi@student.com', 'password' => 'password', 'dosen_id' => $dosen1->id],
            ['nama' => 'Dewi Lestari', 'nim' => '2021002', 'email' => 'dewi@student.com', 'password' => 'password', 'dosen_id' => $dosen1->id],
            ['nama' => 'Eko Prasetyo', 'nim' => '2021003', 'email' => 'eko@student.com', 'password' => 'password', 'dosen_id' => $dosen1->id],
            ['nama' => 'Fitri Handayani', 'nim' => '2021004', 'email' => 'fitri@student.com', 'password' => 'password', 'dosen_id' => $dosen1->id],
            ['nama' => 'Galih Permana', 'nim' => '2021005', 'email' => 'galih@student.com', 'password' => 'password', 'dosen_id' => $dosen1->id],
        ];

        // Create Students for Dosen 2
        $students2 = [
            ['nama' => 'Hendra Wijaya', 'nim' => '2021006', 'email' => 'hendra@student.com', 'password' => 'password', 'dosen_id' => $dosen2->id],
            ['nama' => 'Indah Permata', 'nim' => '2021007', 'email' => 'indah@student.com', 'password' => 'password', 'dosen_id' => $dosen2->id],
            ['nama' => 'Joko Widodo', 'nim' => '2021008', 'email' => 'joko@student.com', 'password' => 'password', 'dosen_id' => $dosen2->id],
        ];

        $allStudentData = array_merge($students1, $students2);
        $levels = ['low', 'moderate', 'high'];

        foreach ($allStudentData as $data) {
            $student = Student::create($data);

            // Create 3-5 stress results per student
            $count = rand(3, 5);
            for ($i = 0; $i < $count; $i++) {
                StressResult::create([
                    'student_id' => $student->id,
                    'level' => $levels[array_rand($levels)],
                    'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                ]);
            }
        }
    }
}
