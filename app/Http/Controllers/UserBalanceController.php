<?php

namespace App\Http\Controllers;

use App\Models\UserBalance;
use Illuminate\Http\Request;

class UserBalanceController extends Controller
{
    public function index()
    {
        return UserBalance::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users'],
            'balance' => ['required', 'numeric'],
            'operation_type_id' => ['required', 'exists:operation_type'],
        ]);

        return UserBalance::create($data);
    }

    public function show(UserBalance $userBalance)
    {
        return $userBalance;
    }

    public function update(Request $request, UserBalance $userBalance)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users'],
            'balance' => ['required', 'numeric'],
            'operation_type_id' => ['required', 'exists:operation_type'],
        ]);

        $userBalance->update($data);

        return $userBalance;
    }

    public function destroy(UserBalance $userBalance)
    {
        $userBalance->delete();

        return response()->json();
    }
}
