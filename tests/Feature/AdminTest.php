<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    private User $owner;
    private User $user;


    protected function setUp(): void
    {
        parent::setUp();
        $this->migrateFreshUsing();
        $this->owner = User::factory()->make(['id' => 1]);
        $this->owner->save();
        $this->user = User::factory()->make(['id' => 2]);
        $this->user->save();
        User::factory()->make(['id' => 3])->save();
    }

    /** @test */
    public function index_accessible_for_all()
    {
        $this->actingAs($this->owner);
        $this->get('/dashboard/users')->assertStatus(200);
        $this->actingAs($this->user);
        $this->get('/dashboard/users')->assertStatus(200);
    }
    /** @test */
    public function destroy_accessible_for_owner()
    {
        $this->actingAs($this->user);
        $this->delete('/dashboard/users/3')->assertStatus(404);
        $this->actingAs($this->owner);
        $this->delete('/dashboard/users/3')->assertStatus(200)->assertJson([
            'msg' =>"data deleted successfully"
        ]);
    }
    /** @test */
    public function create_accessible_for_owner()
    {
        $this->actingAs($this->owner);
        $this->get('/dashboard/users/create')->assertStatus(200);
        $this->actingAs($this->user);
        $this->get('/dashboard/users/create')->assertStatus(404);
    }
    /** @test */
    public function edit_accessible_for_owner_and_profile_owner()
    {
        $this->actingAs($this->owner);
        $this->get('/dashboard/users/3/edit')->assertStatus(200);
        $this->actingAs($this->user);
        $this->get('/dashboard/users/3/edit')->assertStatus(404);
        $this->get('/dashboard/users/2/edit')->assertStatus(200);
    }
    /** @test */
    public function update_accessible_for_owner_and_profile_owner()
    {
        $this->actingAs($this->owner);
        $this->put('/dashboard/users/3',User::factory()->make()->toArray())
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->actingAs($this->user);
        $this->put('/dashboard/users/3',User::factory()->make()->toArray())
            ->assertStatus(404);

        $this->put('/dashboard/users/2',User::factory()->make()->toArray())
            ->assertStatus(302)
            ->assertSessionHas('success');
    }


}
