<?php

namespace Tests\Unit;

use App\Models\Password_Reset_Tokens;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Models\Student;
use App\Mail\ForgotPassword;

class ForgotPasswordControllerTest extends TestCase
{

    use DatabaseTransactions,WithFaker;
    public function testForgotPasswordFormDisplay()
    {
        // Ensure that the user is a guest before making the request
    $this->assertGuest();

    $response = $this->get(route('forgot.password.get'));
    $response->assertStatus(200);
    $response->assertViewIs('auth.forgotPassword');

    }


    }


