<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_creates_a_user_and_a_balance()
    {
        $email = $this->faker->email;
        $userData = [
            'name' => $this->faker->name,
            'email' => $email,
            'password' => $this->faker->password,
        ];

        $user = User::create($userData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $email,
        ]);

        $this->assertDatabaseHas('user_balance', [
            'user_id' => $user->id,
            'balance' => 0,
        ]);
    }
}
