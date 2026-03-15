<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $user->update($validatedData);

        return response()->json(['message' => 'Profile updated!', 'user' => $user->fresh()]);
    }

    public function updateGender(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->gender = $request->gender;
        $user->save();

        return response()->json(['message' => 'Gender updated!', 'user' => $user->fresh()]);
    }
}
