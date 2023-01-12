<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->migrateFreshUsing();
    }

    /** @test */
    public function login_page_exists(){
        $this->get('/login')->assertStatus(200);
    }
    /** @test */
    public function email_is_required(){
        $this->post('/login',['password' => '123456'])
            ->assertStatus(302)
            ->assertSessionDoesntHaveErrors(['password'])
            ->assertSessionHasErrors(['email']);
    }
    /** @test */
    public function email_is_email_format(){
        $this->post('/login',['password' => '123456', 'email'=> 'sdsdffgr'])
            ->assertStatus(302)
            ->assertSessionDoesntHaveErrors(['password'])
            ->assertSessionHasErrors(['email']);
    }
    /** @test */
    public function password_is_required(){
        $this->post('/login',['email' => 'test@test.com'])
            ->assertStatus(302)
            ->assertSessionDoesntHaveErrors(['email'])
            ->assertSessionHasErrors(['password']);
    }

    /** @test
     * @throws \JsonException
     */
    public function wrong_credentials(){
        $this->post('/login',['email' => 'test@test.com' , 'password' => 52])
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertSessionHas('error');
    }

    /** @test
     * @throws \JsonException
     */
    public function client_can_login(){
        Client::factory()->create([
            'email' => 'test@test.com',
            'password' => '123456'
        ]);
        $this->post('/login',['email' => 'test@test.com' , 'password' => 123456])
            ->assertStatus(302)
            ->assertSessionHasNoErrors();
    }

}
