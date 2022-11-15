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
    /**
     * @OA\Post(
     *      path="/auth",
     *      summary="Autenticar e gerar token",
     *      tags={"Auth"},
     *      description="Retorna token de autenticação",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="User Name"),
     *              @OA\Property(property="pwd", type="string", example="12345#qwert")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Token gerado com sucesso.",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", example="1|eoiuywourioeuwoUIymlajsklaOPImewruwopruokhdshjfdf")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Ao falhar na autorização.",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Ao falhar em uma validação.",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="name", items=@OA\Items(
     *                  @OA\Property(type="string")
     *              ))
     *          )
     *      )
     * )
     */
    public function create(LoginRequest $request): JsonResponse
    {
        $user = User::findByName($request->input("name"));

        if (empty($user) || !Hash::check($request->input("pwd"), $user->password))
            return response()->json(null, Response::HTTP_UNAUTHORIZED);

        return response()->json(["token" => $user->createToken("Token")->plainTextToken]);
    }

    /**
     * @OA\Delete(
     *      path="/auth",
     *      summary="Revogar token",
     *      tags={"Auth"},
     *      description="Revoga token de autenticação",
     *      @OA\Header(
     *          header="Authorization",
     *          description="Token de autenticação a ser revogado."
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Token gerado com sucesso."
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Ao falhar na autorização.",
     *      ),
     * )
     */
    public function destroy(Request $request)
    {
        $token = preg_replace("/Bearer \d+\|/mi", "", $request->header("Authorization"));
        $data = PersonalAccessToken::findToken($token);

        if (!empty($data))
            $data->forceDelete();
    }
}
