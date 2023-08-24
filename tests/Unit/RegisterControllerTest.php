<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\File;


class RegisterControllerTest extends TestCase
{

    use WithFaker, DatabaseTransactions;

    public function testAuthenticatedAdminCanRegisterStudent()
    {
        // Mock the mail facade to prevent actual email sending
        Mail::fake();


         // Create an administrator student for testing
         $adminStudent = Student::factory()->create(['isAdmin' => 1]);

         // Authenticate as the administrator student
         Auth::login($adminStudent);

         // Create a student for testing
         #$student = Student::factory()->create();



           // Path to the test image in the testing directory
    $imagePath = storage_path('testing\test_images'); // Path to your test images
    $imageFile = $imagePath . '\test_image.jpg';

    // Copy the test image to the storage directory
    $storagePath = storage_path('\uploads');
    $newImageFile = $storagePath . '\test_image.jpg';
    copy($imageFile, $newImageFile);


         // Generate valid data using Faker
         $data = [
             'name' => $this->faker->name,
             'email' => $this->faker->unique()->safeEmail,
             'phone' => $this->faker->numerify('##########'),
             'address' => $this->faker->address,
             'image' => new UploadedFile($newImageFile, 'test_image.jpg', 'image\jpeg', null, true),
         ];

        // Mock the Image facade to prevent actual image resizing and saving
        $this->mockImageFacade();


        // Send a POST request to the registration route
        $response = $this->post(route('student.store'), $data);

        // Assert that registration was successful
        $response->assertRedirect('/users')
                 ->assertSessionHas('success', 'Registerd and Email sent to user');

        // Assert that the student was created in the database
        $this->assertDatabaseHas('students', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // Assert that a welcome email was sent
        Mail::assertSent(WelcomeMail::class, function ($mail) use ($data) {
            return $mail->hasTo($data['email']);
        });
}


        // Mock the Image facade for testing
        protected function mockImageFacade()
        {
            $mockImage = \Mockery::mock('alias:Image');
            $mockImage->shouldReceive('make->resize->save')->andReturnTrue();

        }
}







