<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    public function create(LoginRequest $request): JsonResponse
    {
        $user = User::findByName($request->input("name"));

        if (empty($user) || !Hash::check($request->input("pwd"), $user->password))
            return response()->json(null, Response::HTTP_UNAUTHORIZED);

        return response()->json(["token" => $user->createToken("Token")->plainTextToken]);
    }

    public function destroy(Request $request)
    {
        $token = preg_replace("/Bearer \d+\|/mi", "", $request->header("Authorization"));
        $data = PersonalAccessToken::findToken($token);

        if (!empty($data))
            $data->forceDelete();
    }
}
