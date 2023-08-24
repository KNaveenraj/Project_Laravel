<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        #Student::factory()->count(10)->create();
        $students = new Student;
        $roles = new Roles;
        $isAdmin = $students->pluck('isAdmin');
        $roleId = $roles->pluck('id');

       /* foreach (range(1,50) as $index) {
        $students->name = fake()->name();
        $students->email = fake()->unique()->safeEmail();
        $students->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';// password
        $students->phone = fake()->unique()->phoneNumber();
        $students->address = fake()->country();
        $students->image = '0kkxqycyface8.jpg';
        $students->isAdmin = fake()->randomElement($isAdmin);

    }
        $students->save();*/


        foreach (range(0,5) as $index) {
            Student::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',// password
            'phone' =>fake()->unique()->numerify('##########'),
            'address' =>fake()->country(),
            'image' => '0kkxqycyface8.jpg',
            'isAdmin' => '3',

            ]);
        }
    }
}
