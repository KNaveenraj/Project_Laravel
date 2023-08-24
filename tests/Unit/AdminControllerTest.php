<?php

namespace Tests\Unit;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Student;

use Illuminate\Support\Facades\Auth; // Import Auth facade

class AdminControllerTest extends TestCase
{
    use DatabaseTransactions,WithFaker;

    /** @test */
    public function it_displays_students_list()
    {
         // Create a student and authenticate
         $student = Student::factory()->create(['isAdmin' => 1]);
         Auth::login($student);

         // Create some sample students for testing
         Student::factory()->create();

         // Send a request to the index method with a search parameter
         $response = $this->actingAs($student)->get(route('admin.student.index', ['search' => 'exampleSearchQuery']));

         // Assert that the response status is 200 (OK)
         $response->assertStatus(200);

         // Assert that the view name is 'admin.student_list'
         $response->assertViewIs('admin.student_list');

         // Assert that the view has a 'students' variable
         $response->assertViewHas('students');

         // Assert that the 'students' variable is a collection of Student objects
         $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $response->viewData('students'));
     }

     public function testEditMethod()
    {
        // Create an administrator student for testing
        $adminStudent = Student::factory()->create(['isAdmin' => 1]);

        // Authenticate as the administrator student
        Auth::login($adminStudent);

        // Create a student for testing
        $student = Student::factory()->create();

        // Send a request to the edit method
        $response = $this->get(route('student.edit', ['student' => $student->id]));


        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the view name is 'admin.student_edit'
        $response->assertViewIs('admin.student_edit');

        // Assert that the view has the 'student' and 'role' variables
        $response->assertViewHas(['student', 'role']);

        // Assert that the 'student' variable is an instance of the Student model
        $this->assertInstanceOf(Student::class, $response->viewData('student'));

        // Assert that the 'role' variable is a collection of Role objects
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $response->viewData('role'));
    }

    public function testUpdateMethod()
    {
        // Create an administrator student for testing
        $adminStudent = Student::factory()->create(['isAdmin' => 1]);

        // Authenticate as the administrator student
        Auth::login($adminStudent);

        // Create a student for testing
        $student = Student::factory()->create();

        // Generate valid data using Faker
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->numerify('##########'),
            'address' => $this->faker->address,
            'isAdmin'=>'3',
            'set_viewable' => '1',
            // Add other data fields as needed
        ];

        // Send a request to the update method
        $response = $this->actingAs($adminStudent)
            ->post(route('student.update', ['student' => $student->id]), $data);

        // Assert that the user is redirected to the edit page after successful update
        $response->assertRedirect(route('student.edit', ['student' => $student->id]));

        // Assert that the student details were updated
        $this->assertEquals($data['name'], $student->fresh()->name);
        $this->assertEquals($data['email'], $student->fresh()->email);
        $this->assertEquals($data['phone'], $student->fresh()->phone);
        $this->assertEquals($data['address'], $student->fresh()->address);
        $this->assertEquals($data['isAdmin'], $student->fresh()->isAdmin);
        $this->assertEquals($data['set_viewable'], $student->fresh()->set_viewable);

        // You can add more assertions based on your application logic
    }

    public function testDeleteMethod()
    {
        // Create an administrator student for testing
        $adminStudent = Student::factory()->create(['isAdmin' => 1]);

        // Authenticate as the administrator student
        Auth::login($adminStudent);

        // Create a student for testing
        $student = Student::factory()->create();

        // Send a request to the delete method
        $response = $this->actingAs($adminStudent)
            ->get(route('student.delete', ['student' => $student->id]));

        // Assert that the user is redirected back
        $response->assertRedirect();

        // Assert that the student was deleted
        $this->assertDatabaseMissing('students', ['id' => $student->id]);


    }

    public function testChangePasswordMethod()
    {
        // Create an administrator student for testing
        $adminStudent = Student::factory()->create(['isAdmin' => 1]);

        // Authenticate as the administrator student
        Auth::login($adminStudent);

        // Mock Hash::make to return a fixed value
        Hash::shouldReceive('make')->once()->andReturn('hashed_password');

        // Generate valid data using Faker
        $data = [
            'email' => $adminStudent->email,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',

        ];

        // Send a request to the changePassword method
        $response = $this->actingAs($adminStudent)
            ->post(route('admin.change', ['student' => $adminStudent->id]), $data);

        // Assert that the user is redirected back
        $response->assertRedirect();

        // Assert that the student password was updated in the database
        $this->assertTrue(Student::where('id', $adminStudent->id)->where('password', 'hashed_password')->exists());

    }

}





