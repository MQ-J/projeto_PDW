<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    public function create(LoginRequest $request):JsonResponse
    {
        $user = User::findByName($request->input("name"));

        if (empty($user) || !Hash::check($request->input("pwd"), $user->password))
            return response()->json(null, Response::HTTP_UNAUTHORIZED);

        return response()->json(["token" => $user->createToken("Token")->plainTextToken]);
    }

    public function destroy()
    {
        //TODO: Implemetar revogação de token
    }
}
