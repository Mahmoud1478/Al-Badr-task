<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ClientValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->migrateFreshUsing();
    }

    /** @test */
    public function client_cannot_register_if_provides_empty_data()
    {
        $this->post('/register')->assertStatus(302)->assertSessionHasErrors([
            'phone', 'first_name', 'last_name', 'image', 'password', 'longitude', 'latitude', 'email'
        ]);
    }

    /** @test */
    public function phone_is_required()
    {
        $this->post('/register', [
            'phone' => null,
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png'),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '80',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'first_name', 'last_name', 'image', 'password', 'longitude', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['phone']);
    }

    /** @test */
    public function phone_is_egyptian_number()
    {
        $this->post('/register', [
            'phone' => '+12345678999',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png'),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '80',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'first_name', 'last_name', 'image', 'password', 'longitude', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['phone']);
    }

    /** @test */
    public function first_name_is_required()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => '',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png'),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '80',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'last_name', 'image', 'password', 'longitude', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['first_name']);
    }

    /** @test */
    public function last_name_is_required()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => '',
            'image' => UploadedFile::fake()->image('testing.png'),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '80',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'image', 'password', 'longitude', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['last_name']);
    }

    /** @test */
    public function image_is_required()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '80',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'password', 'longitude', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['image']);
    }

    /** @test */
    public function image_is_less_than_5001_kilo()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png')->size(5001),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '80',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'password', 'longitude', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['image']);
    }

    /** @test */
    public function image_is_image_format()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->create('testing.txt')->size(5),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '80',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'password', 'longitude', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['image']);
    }

    /** @test */
    public function password_is_required()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png')->size(5),
            'password_confirmation' => '123456',
            'longitude' => '80',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'longitude', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function password_min_count_6()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png')->size(5),
            'password' => '1234',
            'password_confirmation' => '123456',
            'longitude' => '80',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'longitude', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function password_confirmed()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png')->size(5),
            'password' => '123456',
            'password_confirmation' => 'ss',
            'longitude' => '80',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'longitude', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function longitude_is_required()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png')->size(5),
            'password' => '123456',
            'password_confirmation' => '123456',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'password', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['longitude']);
    }

    /** @test */
    public function longitude_is_float()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png')->size(5),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => 'dsadsdddd',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'password', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['longitude']);
    }

    /** @test */
    public function longitude_is_greater_than_negative_180_or_equal()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png')->size(5),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '-190',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'password', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['longitude']);
    }

    /** @test */
    public function longitude_is_less_than_pos_180_or_equal()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png')->size(5),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '190',
            'latitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'password', 'latitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['longitude']);
    }

    /** @test */
    public function latitude_is_required()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png')->size(5),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '80',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'password', 'longitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['latitude']);
    }

    /** @test */
    public function latitude_is_float()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png')->size(5),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '80',
            'latitude' => 'klmlkmn',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'password', 'longitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['latitude']);
    }

    /** @test */
    public function latitude_is_greater_than_negative_90_or_equal()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png')->size(5),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '-180',
            'latitude' => '-100',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'password', 'longitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['latitude']);
    }

    /** @test */
    public function latitude_is_less_than_pos_90_or_equal()
    {
        $this->post('/register', [
            'phone' => '01023210100',
            'first_name' => 'mahmoud',
            'last_name' => 'mostafa',
            'image' => UploadedFile::fake()->image('testing.png')->size(5),
            'password' => '123456',
            'password_confirmation' => '123456',
            'longitude' => '180',
            'latitude' => '100',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'password', 'longitude', 'email'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['latitude']);
    }

    /** @test */
    public function email_is_required()
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
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'password', 'longitude', 'latitude'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function email_is_email_format()
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
            'email' => 'fskdnfk'
        ])
            ->assertSessionDoesntHaveErrors([
                'phone', 'first_name', 'last_name', 'image', 'password', 'longitude', 'latitude'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function email_is_unique()
    {
        Client::factory()->create([
            'email' => 'test@test.com'
        ]);
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
                'phone', 'first_name', 'last_name', 'image', 'password', 'longitude', 'latitude'
            ])
            ->assertStatus(302)->assertSessionHasErrors(['email']);
    }
}
