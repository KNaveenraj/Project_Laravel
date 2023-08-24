<?php

namespace Tests\Unit;

use App\Models\Student;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions;
    public function testChangePasswordMethod()
    {
        // Create an administrator student for testing
        $student = Student::factory()->create(['isAdmin' => 3]);

        // Authenticate as the  student
        Auth::login($student);


        // Mock Hash::make to return a fixed value
        Hash::shouldReceive('make')->once()->andReturn('hashed_password');

        // Generate valid data using Faker
        $data = [
            'email' => $student->email,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',

        ];

        // Send a request to the changePassword method
        $response = $this->actingAs($student)
            ->post(route('user.change', ['student' => $student->id]), $data);

        // Assert that the user is redirected back
        $response->assertRedirect();

        // Assert that the student password was updated in the database
        $this->assertTrue(Student::where('id', $student->id)->where('password', 'hashed_password')->exists());

    }



}
