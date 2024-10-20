<?php

namespace Tests\Feature;

use App\Jobs\BalanceOperationJob;
use App\Models\OperationType;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BalanceOperationTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function testIndex()
    {
        $response = $this->getJson('api/balance-operation');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testStore()
    {
        \Queue::fake();
        $data = [
            'amount' => $this->faker->numberBetween(0, 1000),
            'operation_type_id' => OperationType::where('name', 'credit')->value('id'),
            'description' => $this->faker->text(),
        ];
        $response = $this->postJson('api/balance-operation', $data);
        $response->assertStatus(204);
        \Queue::assertPushed(BalanceOperationJob::class, function ($job) use ($data) {
            return $job->getData()['operation']['id'] === $data['operation_type_id'] && $job->getData()['amount'] === $data['amount'];
        });
    }
}
