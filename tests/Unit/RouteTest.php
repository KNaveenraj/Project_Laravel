<?php

namespace Tests\Unit;

use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response = $this->get('forgot-password');
        $response->assertStatus(200);
        $response = $this->get('reset-password/{token}');
        $response->assertStatus(200);
    }
}
