<?php

namespace App\Http\Controllers;

use App\Models\OperationType;
use Illuminate\Http\Request;

class OperationTypeController extends Controller
{
    public function index()
    {
        return OperationType::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'title' => ['required'],
        ]);

        return OperationType::create($data);
    }

    public function show(OperationType $operationType)
    {
        return $operationType;
    }

    public function update(Request $request, OperationType $operationType)
    {
        $data = $request->validate([
            'name' => ['required'],
            'title' => ['required'],
        ]);

        $operationType->update($data);

        return $operationType;
    }

    public function destroy(OperationType $operationType)
    {
        $operationType->delete();

        return response()->json();
    }
}
