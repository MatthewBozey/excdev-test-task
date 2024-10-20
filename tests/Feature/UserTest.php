<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(
            User::factory()->create(), []
        );
    }

    public function testIndex()
    {
        $response = $this->getJson('api/users');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['*' => ['id', 'name', 'email', 'balance' => ['balance', 'user_id']]]]);
    }

    public function testStoreWithFailedValidation()
    {
        $response = $this->postJson('api/users', []);
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'error_list']);
    }

    public function testStoreWithExistsUserEmail()
    {
        $user = User::factory()->create();
        $response = $this->postJson('api/users', $user->toArray());
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'error_list']);
    }

    public function testStoreUser()
    {
        $user = User::factory()->make()->toArray();
        $password = $this->faker->password();
        $user['password'] = $password;
        $user['password_confirmation'] = $password;
        $response = $this->postJson('api/users', $user);
        unset($user['password_confirmation']);
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['id', 'name', 'email', 'balance' => ['balance', 'user_id']]]);
        $this->assertDatabaseHas('users', ['email' => $user['email']]);
    }

    public function testShow()
    {
        $user = User::factory()->create();
        $response = $this->getJson('api/users/'.$user->id);
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['id', 'name', 'email', 'balance' => ['balance', 'user_id']]]);
        $this->assertEquals($user->id, $response['data']['id']);
    }

    public function testShowDoesntExists()
    {
        $response = $this->getJson('api/users/99999999');
        $response->assertStatus(404);
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create();
        $user->name = $this->faker->name();
        $response = $this->putJson('api/users/'.$user->id, $user->toArray());
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['id', 'name', 'email', 'balance' => ['balance', 'user_id']]]);
    }

    public function testUpdateWithExistsUserEmail()
    {
        $user = User::factory()->create();
        $user->email = User::inRandomOrder()->value('email');
        $response = $this->putJson('api/users/'.$user->id, $user->toArray());
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'error_list']);
    }

    public function testUserDelete()
    {
        $user = User::factory()->create();
        $response = $this->deleteJson('api/users/'.$user->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
