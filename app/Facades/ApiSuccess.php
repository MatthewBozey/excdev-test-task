<?php

namespace App\Facades;

use App\Http\Response\ApiSuccessResponse;
use Illuminate\Support\Facades\Facade;

class ApiSuccess extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'api.success';
    }

    public static function withData($data, $code = 200, $metadata = [], $headers = []): ApiSuccessResponse
    {
        return new ApiSuccessResponse($data, $code, $metadata, $headers);
    }

    public static function withoutData($data = null, $code = 204, $metadata = [], $headers = []): ApiSuccessResponse
    {
        return new ApiSuccessResponse($data, $code, $metadata, $headers);
    }
}
