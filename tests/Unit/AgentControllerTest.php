<?php

namespace Tests\Unit;

use App\Models\Student;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;


class AgentControllerTest extends TestCase
{

    use DatabaseTransactions,WithFaker;

    public function testIndexsMethod()
    {
        // Create a user with the necessary roles
        $user = Student::factory()->create(['isAdmin' => 2]);
        Auth::login($user);

        // Create some students
        Student::factory()->create(['set_viewable' => 1, 'isAdmin' => 3]);

        // Make a request to the indexs method
        $response = $this->get(route('agent.student.indexs'));

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the 'agents/agents_list' view is being used
        $response->assertViewIs('agents.agents_list');

        // Assert that the students are being passed to the view
        $response->assertViewHas('students');

        // Assert that the students are paginated and 10 are shown per page
        $response->assertViewHas('students', function ($students) {
            return $students->count() <= 10;
        });
    }



    /**
     * Summary of testEditMethod
     * @return void
     */
    public function testEditMethod()
    {
        // Create a user with the necessary roles
        $user = Student::factory()->create(['isAdmin' => 2]);
        Auth::login($user);

        // Create a student
        $student =  Student::factory()->create(['set_viewable' => 1, 'isAdmin' => 3]);

        // Make a request to the edit method
        $response = $this->get(route('agent.edit', ['student' => $student->id]));

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the 'agents/agent_edit' view is being used
        $response->assertViewIs('agents.agent_edit');

        // Assert that the student data is being passed to the view
        $response->assertViewHas('student', $student);
    }

    public function testModifyMethod()
    {
        // Create a user with the necessary roles
        $user = Student::factory()->create(['isAdmin' => 2]);
        Auth::login($user);

        // Create a student
        $student = Student::factory()->create(['set_viewable' => 1, 'isAdmin' => 3]);

        // Make a request to the modify method with valid data
        $data = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '1234567890',
            'address' => 'Updated Address',
        ];
        $response = $this->post(route('agent.update', ['student' => $student->id]), $data);

        // Assert that the student details are updated in the database
        $this->assertDatabaseHas('students', $data);

        // Assert that the response redirects to the edit route with success message
        $response->assertRedirect(route('agent.edit', $student));
        $response->assertSessionHas('success', 'Student details updated successfully!');

        // Make a request to the modify method with invalid data
        $invalidData = [
            'name' => '',
            'email' => 'invalid-email',
            'phone' => '123',
            'address' => '',
        ];
        $response = $this->post(route('agent.update', ['student' => $student->id]), $invalidData);

        // Assert that the response redirects back with validation errors
        $response->assertSessionHasErrors(['name', 'email', 'phone', 'address']);
    }


    public function testSetViewMethodSuccess()
    {
        // Create a user with the necessary roles
        $user = Student::factory()->create(['isAdmin' => 2]);
        Auth::login($user);

        // Create a student
        $student = Student::factory()->create(['set_viewable' => 1, 'isAdmin' => 3]);

        // Make a request to the setView method
        $response = $this->get(route('agent.delete',['student' => $student->id] ));

        // Assert that the student's set_viewable field is updated to 0
        $this->assertDatabaseHas('students', ['id' => $student->id, 'set_viewable' => 0]);

        // Assert that the response redirects to the indexs route with success message
        $response->assertRedirect(route('agent.student.indexs'));
        $response->assertSessionHas('success', 'success');
    }

    public function testSetViewMethodFailure()
    {

        // Create a user with the necessary roles
        $user = Student::factory()->create(['isAdmin' => 2]);
        Auth::login($user);

        // Make a request to the setView method
        $response = $this->get(route('agent.delete', ['student'=>$user->id]));

        // Assert that the student's set_viewable field is not updated
        $this->assertDatabaseHas('students', ['id' => $user->id, 'set_viewable' => 1]);

        // Assert that the response redirects to the indexs route with error message
        $response->assertRedirect(route('agent.student.indexs'));
        $response->assertSessionHasErrors(['error' => 'You cant delete your record!']);
    }

    public function testChangePasswordMethod()
    {
        // Create an administrator student for testing
        $agentStudent = Student::factory()->create(['isAdmin' => 2]);

        // Authenticate as the administrator student
        Auth::login($agentStudent);

        // Mock Hash::make to return a fixed value
        Hash::shouldReceive('make')->once()->andReturn('hashed_password');

        // Generate valid data using Faker
        $data = [
            'email' => $agentStudent->email,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',

        ];

        // Send a request to the changePassword method
        $response = $this->actingAs($agentStudent)
            ->post(route('agent.change', ['student' => $agentStudent->id]), $data);

        // Assert that the user is redirected back
        $response->assertRedirect();

        // Assert that the student password was updated in the database
        $this->assertTrue(Student::where('id', $agentStudent->id)->where('password', 'hashed_password')->exists());

    }

}
