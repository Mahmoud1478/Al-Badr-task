<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ClientPermissionsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->migrateFreshUsing();
        $this->user = User::factory()->make(['id'=>1]);
        $this->user->save();
    }
    private function newData(): array
    {
        return array_merge(
            Client::factory()->make([
                'image' => UploadedFile::fake()->image('testing.png')->size('5'),
                'password_confirmation' => 123456
            ])->toArray(),
            ['password' => 123456]);
    }
    /** @test */
    public function index_accessible_for_owner_and_user_who_has_the_right_permission()
    {
        // id = 1 owner
        $this->actingAs($this->user);

        $this->get('/dashboard/clients')->assertStatus(200);
        $this->user->id = 2;
        $this->user->save();
        $this->get('/dashboard/clients')->assertStatus(404);
        $this->user->update([
            'permissions' => ['create-clients']
        ]);
        $this->get('/dashboard/clients')->assertStatus(200);
    }
    /** @test */
    public function create_accessible_for_owner_and_user_who_has_the_right_permission()
    {
        // id = 1 owner
        $this->actingAs($this->user);
        $this->get('/dashboard/clients/create')->assertStatus(200);
        $this->user->id = 2;
        $this->user->save();
        $this->get('/dashboard/clients')->assertStatus(404);
        $this->user->update([
            'permissions' => ['create-clients']
        ]);
        $this->get('/dashboard/clients')->assertStatus(200);
    }
    /** @test */
    public function store_accessible_for_owner_and_user_who_has_the_right_permission()
    {
        // id = 1 owner
        $this->actingAs($this->user);
        $this->post('/dashboard/clients',$this->newData())->assertStatus(302)->assertSessionHas('success');
        $this->user->id = 2;
        $this->user->save();;
        $this->post('/dashboard/clients',$this->newData())->assertStatus(404);
        $this->user->update(['permissions' => ['create-clients']]);
        $this->post('/dashboard/clients',$this->newData())->assertStatus(302)->assertSessionHas('success');
    }
    /** @test */
    public function edit_accessible_for_owner_and_user_who_has_the_right_permission()
    {
        // id = 1 owner
        $this->actingAs($this->user);
        Client::factory()->make(['id'=>1])->save();
        $this->get('/dashboard/clients/1/edit')->assertStatus(200);
        $this->user->id = 2;
        $this->user->save();;
        $this->get('/dashboard/clients/1/edit')->assertStatus(404);
        $this->user->update(['permissions' => ['update-clients']]);
        $this->get('/dashboard/clients/1/edit')->assertStatus(200);
    }
    /** @test */
    public function update_accessible_for_owner_and_user_who_has_the_right_permission()
    {
        // id = 1 owner
        $this->actingAs($this->user);
        Client::factory()->make(['id'=>1])->save();
        $this->put('/dashboard/clients/1',$this->newData())->assertStatus(302)->assertSessionHas('success');
        $this->user->id = 2;
        $this->user->save();;
        $this->put('/dashboard/clients/1',$this->newData())->assertStatus(404);
        $this->user->update(['permissions' => ['update-clients']]);
        $this->put('/dashboard/clients/1',$this->newData())->assertStatus(302)->assertSessionHas('success');
    }
    /** @test */
    public function delete_accessible_for_owner_and_user_who_has_the_right_permission()
    {
        // id = 1 owner
        $this->actingAs($this->user);
        Client::factory()->make(['id'=>1])->save();
        $this->delete('/dashboard/clients/1')->assertStatus(200);
        Client::factory()->make(['id'=>1])->save();
        $this->user->id = 2;
        $this->user->save();;
        $this->delete('/dashboard/clients/1')->assertStatus(403);
        $this->user->update(['permissions' => ['delete-clients']]);
        $this->delete('/dashboard/clients/1',$this->newData())->assertStatus(200);
    }

    /** @test */
    public function activate_accessible_for_owner_and_user_who_has_the_right_permission()
    {
        // id = 1 owner
        $this->actingAs($this->user);
        Client::factory()->make(['id'=>1])->save();
        $this->patch('/dashboard/clients/toggle_status/1')->assertStatus(200);
        $this->user->id = 2;
        $this->user->save();;
        $this->patch('/dashboard/clients/toggle_status/1')->assertStatus(404);
        $this->user->update(['permissions' => ['activate-clients']]);
        $this->patch('/dashboard/clients/toggle_status/1')->assertStatus(200);
    }
}
