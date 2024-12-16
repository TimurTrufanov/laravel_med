<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctor\LoginRequest;
use App\Http\Resources\DoctorDetailedResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password) || !$user->doctor) {
            return response()->json(['message' => 'Невірні дані для входу'], 401);
        }

        $token = $user->createToken('doctor-token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }


    public function getDetails(Request $request)
    {
        $doctor = $request->user()->doctor;

        return DoctorDetailedResource::make($doctor->load(['clinic', 'specializations']))->resolve();
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
