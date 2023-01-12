<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->migrateFreshUsing();
    }

    /** @test */
    public function register_page_exists()
    {
        $this->get('/register')->assertStatus(200);
    }

    /** @test */
    public function client_can_register()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png')->size(5),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '180',
            'latitude' => '90',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'password', 'longitude', 'latitude', 'email'
            ])
            ->assertStatus(302);
    }
}
