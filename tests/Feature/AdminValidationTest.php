<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminValidationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->migrateFreshUsing();
        $this->user = User::factory()->make(['id'=> 1, 'email'=> 'test@test.com']);
        $this->user->save();
    }

    /** @test */
    public function name_is_required()
    {
        $this->actingAs($this->user);
        $this->post('/dashboard/users', [
            'name' => '',
            'password' => '123456',
            'password_confirmation' => '123456',
            'email' => 'test2@test.com'
        ])
            ->assertSessionDoesntHaveErrors(['password', 'email'])
            ->assertStatus(302)->assertSessionHasErrors(['name']);
    }
    /** @test */
    public function password_is_required()
    {
        $this->actingAs($this->user);
        $this->post('/dashboard/users', [
            'name' => 'mahmoud',
            'password' => '',
            'password_confirmation' => '123456',
            'email' => 'test2@test.com'
        ])
            ->assertSessionDoesntHaveErrors(['name', 'email'])
            ->assertStatus(302)->assertSessionHasErrors(['password']);
    }
    /** @test */
    public function password_is_confirmed()
    {
        $this->actingAs($this->user);
        $this->post('/dashboard/users', [
            'name' => 'mahmoud',
            'password' => '123456',
            'password_confirmation' => '1dsacscds',
            'email' => 'test2@test.com'
        ])
            ->assertSessionDoesntHaveErrors(['name', 'email'])
            ->assertStatus(302)->assertSessionHasErrors(['password']);
    }
    /** @test  */
    public function password_min_6_chars()
    {
        $this->actingAs($this->user);
        $this->post('/dashboard/users', [
            'name' => 'mahmoud',
            'password' => '1234',
            'password_confirmation' => '1234',
            'email' => 'test2@test.com'
        ])
            ->assertSessionDoesntHaveErrors(['name', 'email'])
            ->assertStatus(302)->assertSessionHasErrors(['password']);
    }
    /** @test  */
    public function email_is_required()
    {
        $this->actingAs($this->user);
        $this->post('/dashboard/users', [
            'name' => 'mahmoud',
            'password' => '123456',
            'password_confirmation' => '123456',
            'email' => ''
        ])
            ->assertSessionDoesntHaveErrors(['name', 'password'])
            ->assertStatus(302)->assertSessionHasErrors(['email']);
    }
    /** @test  */
    public function email_is_in_email_format()
    {
        $this->actingAs($this->user);
        $this->post('/dashboard/users', [
            'name' => 'mahmoud',
            'password' => '123456',
            'password_confirmation' => '123456',
            'email' => 'fvnjkfndjvhfbhj'
        ])
            ->assertSessionDoesntHaveErrors(['name', 'password'])
            ->assertStatus(302)->assertSessionHasErrors(['email']);
    }
    /** @test  */
    public function email_is_unique()
    {
        $this->actingAs($this->user);
        $this->post('/dashboard/users', [
            'name' => 'mahmoud',
            'password' => '123456',
            'password_confirmation' => '123456',
            'email' => 'test@test.com'
        ])
            ->assertSessionDoesntHaveErrors(['name', 'password'])
            ->assertStatus(302)->assertSessionHasErrors(['email']);
    }


}
