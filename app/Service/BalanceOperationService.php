<?php

namespace App\Service;

use App\Facades\ApiSuccess;
use App\Filters\BalanceOperationFilter;
use App\Helpers\BalanceOperationHelper;
use App\Http\Requests\BalanceOperation\BalanceOperationCreateRequest;
use App\Http\Response\ApiSuccessResponse;
use App\Jobs\BalanceOperationJob;
use App\Models\BalanceOperation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BalanceOperationService extends BaseService
{
    public function __construct()
    {
        $this->model = BalanceOperation::class;
        $this->relations = ['operationType'];
    }

    public function get(Request $request): ApiSuccessResponse
    {
        $filter = app(BalanceOperationFilter::class);

        return ApiSuccess::withData($this->model::where('user_id', $request->user()->id)
            ->filter($filter)
            ->orderByDesc('operation_date')
            ->with($this->relations)
            ->get());
    }

    /**
     * @throws \Exception
     */
    public function execOperation(BalanceOperationHelper $helper, BalanceOperationCreateRequest $request): ApiSuccessResponse
    {
        $requestData = $request->validated();
        $user = auth()->user();

        $balance = $helper->generateBalanceUser($requestData['amount'], $requestData['operation_type_id'], $user);
        $data = [
            'user' => $user,
            'operation_date' => Carbon::now()->timezone('Europe/Moscow'),
            'amount' => $requestData['amount'],
            'operation' => ['id' => $requestData['operation_type_id']],
            'balance' => $balance,
            'description' => $requestData['description'],
        ];
        BalanceOperationJob::dispatch($data);

        return ApiSuccess::withoutData();
    }
}
