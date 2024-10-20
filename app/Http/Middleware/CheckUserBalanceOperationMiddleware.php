<?php

namespace App\Http\Middleware;

use App\Helpers\BalanceOperationHelper;
use App\Http\Response\ApiErrorResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserBalanceOperationMiddleware
{
    /**
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $helper = app(BalanceOperationHelper::class);
        $user = auth()->user();
        $check = $helper->checkUserBalance($request->get('amount'), $request->get('operation_type_id'), $user);

        if (! $check) {
            return new ApiErrorResponse('Произошла ошибка при изменении баланса');
        }

        return $next($request);
    }
}
