<?php

namespace App\Helpers;

use App\Models\OperationType;

class BalanceOperationHelper
{
    public function generateBalanceUser($amount, $operation, $user): float
    {
        $balance = $user->balance->balance;
        $operation_type = OperationType::findOrFail($operation);
        switch ($operation_type->name) {
            case OperationType::CREDIT:
                $balance += $amount;
                break;
            case OperationType::DEBIT:
                if ($balance < $amount || ($balance - $amount < 0)) {
                    throw new \Exception('Недостаточно средств на балансе');
                }
                $balance -= $amount;
                break;
            default:
                throw new \Exception('Неизвестный вид операции');
        }

        return $balance;
    }

    /**
     * @throws \Exception
     */
    public function checkUserBalance($amount, $operation, $user): bool
    {
        $balance = $user->balance->balance;
        $operation_type = OperationType::findOrFail($operation);

        return match ($operation_type->name) {
            OperationType::CREDIT => true,
            OperationType::DEBIT => ! ($balance < $amount || ($balance - $amount < 0)),
            default => throw new \Exception('Неизвестный вид операции'),
        };

    }
}
