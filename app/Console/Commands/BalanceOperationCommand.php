<?php

namespace App\Console\Commands;

use App\Helpers\BalanceOperationHelper;
use App\Jobs\BalanceOperationJob;
use App\Models\OperationType;
use App\Models\User;
use Illuminate\Console\Command;

class BalanceOperationCommand extends Command
{
    protected $signature = 'balance:operation';

    protected $description = 'Выполнение операций с балансом пользователя';

    /**
     * @throws \Exception
     */
    public function handle(BalanceOperationHelper $helper)
    {
        $email = $this->ask('Введите Электронную почту');
        $this->checkEmail($email);
        $user = User::where('email', $email)->first();
        $this->checkUser($user);
        $amount = (float) $this->ask('Введите сумму операции');
        $this->checkAmount($amount);

        $operation_type_choise = $this->choice('Выберите вид операции', OperationType::get()->pluck('title')->toArray());
        $operation_type = OperationType::where('title', $operation_type_choise)->first();
        $description = $this->ask('Введите описание операции');

        $balance = $helper->generateBalanceUser($amount, $operation_type->id, $user);

        $data = [
            'user' => $user->toArray(),
            'operation' => $operation_type->toArray(),
            'balance' => $balance,
            'description' => $description,
            'amount' => $amount,
        ];

        BalanceOperationJob::dispatch($data);

    }

    private function checkEmail($email)
    {
        if (is_null($email) || empty($email)) {
            throw new \InvalidArgumentException('Необходимо ввести Электронную почту пользователя');
        }
    }

    private function checkUser($user)
    {
        if (! $user) {
            throw new \InvalidArgumentException('Пользователь с такой электронной почтой не найден');
        }
    }

    private function checkAmount(mixed $amount)
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Сумма операции должна быть положительной');
        }
    }
}
