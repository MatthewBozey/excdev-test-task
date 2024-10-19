<?php

namespace App\Service;

use App\Facades\ApiSuccess;
use App\Http\Requests\Main\CreateRequest;
use App\Http\Requests\Main\UpdateRequest;
use App\Http\Response\ApiSuccessResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;

class BaseService
{
    protected mixed $model;
    protected string $storeRequest = CreateRequest::class;
    protected string $updateRequest = UpdateRequest::class;
    protected array $relations = [];
    protected string $orderField = 'id';


    public function get(\Illuminate\Http\Request $request): ApiSuccessResponse
    {
        return ApiSuccess::withData($this->model::orderBy($this->orderField)->with($this->relations)->get());
    }
    /**
     * @throws BindingResolutionException
     */
    public function store(Request $request): ApiSuccessResponse
    {
        $request = app()->make($this->storeRequest, $request->all());

        return ApiSuccess::withData($this->model::create($request->validated())->load($this->relations));
    }

    public function show(Request $request): ApiSuccessResponse
    {
        return ApiSuccess::withData($this->model::findOrFail($request->route('id'))->load($this->relations));
    }

    /**
     * @throws BindingResolutionException
     */
    public function update(Request $request): ApiSuccessResponse
    {
        $request = app()->make($this->updateRequest, $request->all());
        $item = $this->model::findOrFail($request->route('id'));
        $item->update($request->validated());

        return ApiSuccess::withData($item->load($this->relations));
    }

    public function destroy(Request $request): ApiSuccessResponse
    {
        $item = $this->model::findOrFail($request->route('id'));
        $item->delete();

        return ApiSuccess::withData($item);
    }

    public function getModel(): mixed
    {
        return $this->model;
    }

    public function setModel(mixed $model): void
    {
        $this->model = $model;
    }
}
