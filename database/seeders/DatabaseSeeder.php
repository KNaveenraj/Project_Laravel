<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

    /*  DB::table('students')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@#'),
            'phone' =>'1234567890',
            'address' =>'India',
            'image' => 'images/1.png',
            'isAdmin' => '1'
         ]);*/


         $student = new Student;

         $student->name = 'admin';
         $student->email = 'admin@gmail.com';
         $student->password = Hash::make('admin@#');
         $student->phone = '1234567890';
         $student->address = 'India';
         $student->image = 'tn34fAdmin.jpg';
         $student->isAdmin = '1';

         $student->save();
    }
}
