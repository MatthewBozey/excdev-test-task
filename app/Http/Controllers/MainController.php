<?php

namespace App\Http\Controllers;

use App\Http\Response\ApiSuccessResponse;
use App\Service\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;

abstract class MainController extends Controller
{

    protected BaseService $service;

    public function __construct(BaseService $service)
    {
        $this->service = $service;
    }


    public function index(Request $request): ApiSuccessResponse
    {
        return $this->service->get($request);
    }

    public function show(Request $request): ApiSuccessResponse
    {
        return $this->service->show($request);
    }

    public function destroy(Request $request): ApiSuccessResponse
    {
        return $this->service->destroy($request);
    }

    /**
     * @throws BindingResolutionException
     */
    public function store(Request $request): ApiSuccessResponse
    {
        return $this->service->store($request);
    }

    /**
     * @throws BindingResolutionException
     */
    public function update(Request $request)
    {
        return $this->service->update($request);
    }
}
