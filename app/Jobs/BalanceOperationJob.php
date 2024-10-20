<?php

namespace App\Jobs;

use App\Models\BalanceOperation;
use App\Models\UserBalance;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class BalanceOperationJob implements ShouldQueue
{
    use Queueable;

    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(): void
    {
        \DB::beginTransaction();

        try {
            BalanceOperation::create([
                'user_id' => $this->data['user']['id'],
                'amount' => $this->data['amount'],
                'description' => $this->data['description'],
                'operation_date' => Carbon::now()->timezone('Europe/Moscow'),
                'operation_type_id' => $this->data['operation']['id'],
            ]);
            UserBalance::updateOrCreate(
                ['user_id' => $this->data['user']['id']],
                ['balance' => $this->data['balance']]
            );
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

    }

    public function getData(): array
    {
        return $this->data;
    }
}
