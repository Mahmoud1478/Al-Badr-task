<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    protected function setUp(): void
    {
        parent::setUp();
        $this->migrateFreshUsing();
    }

    public function login_page_exists(){
        $this->get('/dashboard/login')->assertStatus(200);
    }
    /** @test */
    public function email_is_required(){
        $this->post('/dashboard/login',['password' => '123456'])
            ->assertStatus(302)
            ->assertSessionDoesntHaveErrors(['password'])
            ->assertSessionHasErrors(['email']);
    }
    /** @test */
    public function email_is_email_format(){
        $this->post('/dashboard/login',['password' => '123456', 'email'=> 'sdsdffgr'])
            ->assertStatus(302)
            ->assertSessionDoesntHaveErrors(['password'])
            ->assertSessionHasErrors(['email']);
    }
    /** @test */
    public function password_is_required(){
        $this->post('/dashboard/login',['email' => 'test@test.com'])
            ->assertStatus(302)
            ->assertSessionDoesntHaveErrors(['email'])
            ->assertSessionHasErrors(['password']);
    }

    /** @test
     * @throws \JsonException
     */
    public function wrong_credentials(){
        $this->post('/dashboard/login',['email' => 'test@test.com' , 'password' => 52])
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertSessionHas('error');
    }

    /** @test
     * @throws \JsonException
     */
    public function client_can_login(){
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => '123456'
        ]);
        $this->post('/dashboard/login',['email' => 'test@test.com' , 'password' => 123456])
            ->assertStatus(302)
            ->assertSessionHasNoErrors();
    }
}
