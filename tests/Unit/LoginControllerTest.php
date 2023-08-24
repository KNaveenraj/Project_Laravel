<?php

namespace Tests\Unit;

use App\Models\Student;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Auth\GenericUser;

class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

  /*  public function testAdminLogin()
    {
        // Create an admin student
        $adminStudent = Student::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('adminpassword'),
            'isAdmin' => 1,
            'set_viewable'=>1
        ]);

        // Attempt to log in as an admin
        $response = $this->post('/authenticate', [
            'email' => 'admin@example.com',
            'password' => 'adminpassword',
        ]);

        // Assert that the admin user was redirected to the admin page
        $response->assertRedirect('/admin');
    }

    public function testAgentLogin()
    {
        // Create an admin student
        $adminStudent = Student::factory()->create([
            'email' => 'agent@example.com',
            'password' => bcrypt('agentpassword'),
            'isAdmin' => 2,
            'set_viewable'=>1
        ]);

        // Attempt to log in as an admin
        $response = $this->post('/authenticate', [
            'email' => 'agent@example.com',
            'password' => 'agentpassword',
        ]);

        // Assert that the admin user was redirected to the admin page
        $response->assertRedirect('/agent');
    }

    public function testStudentLogin()
    {
        // Create a test student
        $student = Student::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('testpassword'),
            'isAdmin' => 3,
            'set_viewable'=>1
        ]);

        // Attempt to log in with correct credentials
        $response = $this->post('/authenticate', [
            'email' => 'test@example.com',
            'password' => 'testpassword',
        ]);

        // Assert that the user was redirected to the appropriate page for the student role
        $response->assertRedirect('/student');
    }*/


    public function testInvalidLogin()
    {
        $this->refreshApplication();
$this->startSession();
        // Attempt to log in with incorrect credentials
        $response = $this->post('/authenticate', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        // Follow the redirect and assert the content on the redirected page
        $response->assertStatus(302); // Make sure it's a redirect
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email', 'password']);

        // Follow the redirect and assert the content on the redirected page
        $response = $this->get($response->headers->get('Location'));
        $response->assertViewIs('auth.login'); // Replace with your actual view name

    }



    public function testAuthenticateAdminUser()
    {
        // Create a test student with admin role
        $student = Student::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Hashed password
            'isAdmin' => 1,
            'set_viewable' => 1,
        ]);

        // Act: Perform authentication
        $response = $this->post('/authenticate', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        // Assert that the user was authenticated and redirected to '/admin'
        $response->assertRedirect('/admin');

        // Assert that the authenticated user matches the created student
        $this->assertTrue(Auth::check());
        $this->assertEquals($student->id, Auth::user()->id);
    }

    public function testAuthenticateAgentUser()
    {
        // Create a test student with agent role
        $student = Student::factory()->create([
            'email' => 'agent@example.com',
            'password' => bcrypt('password'), // Hashed password
            'isAdmin' => 2,
            'set_viewable' => 1,
        ]);

        // Act: Perform authentication
        $response = $this->post('/authenticate', [
            'email' => 'agent@example.com',
            'password' => 'password',
        ]);

        // Assert that the user was authenticated and redirected to '/agent'
        $response->assertRedirect('/agent');

        // Assert that the authenticated user matches the created student
        $this->assertTrue(Auth::check());
        $this->assertEquals($student->id, Auth::user()->id);
    }

    public function testAuthenticateStudentUser()
    {
        // Create a test student with student role
        $student = Student::factory()->create([
            'email' => 'student@example.com',
            'password' => bcrypt('password'), // Hashed password
            'isAdmin' => 3,
            'set_viewable' => 1,
        ]);

        // Act: Perform authentication
        $response = $this->post('/authenticate', [
            'email' => 'student@example.com',
            'password' => 'password',
        ]);

        // Assert that the user was authenticated and redirected to '/student'
        $response->assertRedirect('/user');

        // Assert that the authenticated user matches the created student
        $this->assertTrue(Auth::check());
        $this->assertEquals($student->id, Auth::user()->id);
    }

    public function testAuthenticateDisabledUser()
    {
        // Create a test student with disabled user role
        $student = Student::factory()->create([
            'email' => 'disabled@example.com',
            'password' => bcrypt('password'), // Hashed password
            'isAdmin' => 1,
            'set_viewable' => 0,
        ]);

        // Act: Perform authentication
        $response = $this->post('/authenticate', [
            'email' => 'disabled@example.com',
            'password' => 'password',
        ]);

        // Assert that the user was logged out and redirected to '/login'
        $response->assertRedirect('/login');

        // Assert that the user is not authenticated
        $this->assertFalse(Auth::check());

        // Assert that the session contains the 'error' key with the correct message
        $this->assertTrue(session()->has('error'));
        $this->assertEquals('User is Disabled!', session('error'));
    }


    public function testLogout()
    {
        // Create a test user
        $user = Student::factory()->create();

        // Act: Authenticate the user
        $this->actingAs($user);

        // Act: Perform logout
        $response = $this->get('/logout');

        // Assert that the user was logged out and redirected to the login page
        $response->assertRedirect('/login');

        // Assert that the session contains the 'Alert' key with the correct message
        $this->assertTrue(session()->has('Alert'));
        $this->assertEquals('Logged Out', session('Alert'));

        // Assert that the user is no longer authenticated
        $this->assertGuest();
    }





}
