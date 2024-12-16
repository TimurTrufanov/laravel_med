<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Patient\LoginRequest;
use App\Http\Requests\Api\Patient\RegisterRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password) || !$user->patient) {
            return response()->json(['message' => 'Невірні дані для входу'], 401);
        }

        $token = $user->createToken('patient-token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create(array_merge(
            $request->validated(),
            ['password' => Hash::make($request->password), 'role_id' => 1]
        ));

        Patient::create(['user_id' => $user->id]);

        $token = $user->createToken('patient-token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
