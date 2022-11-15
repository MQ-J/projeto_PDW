<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @OA\Post(
     *      path="/user",
     *      tags={"User"},
     *      summary="Criar usuário.",
     *      description="Cria um novo usuário.",
     *
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="User Name"),
     *              @OA\Property(property="email", type="string", example="email@example.com"),
     *              @OA\Property(property="pwd", type="string", example="12345#qwert")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Usuário criado com sucesso.",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="User Name"),
     *              @OA\Property(property="email", type="string", example="email@example.com"),
     *              @OA\Property(property="updated_at", type="string", example="2022-11-14T00:06:03.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2022-11-14T00:06:03.000000Z"),
     *              @OA\Property(property="id", type="int", example="1")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=409,
     *          description="Caso já exista um usuário com o mesmo nome e/ou e-mail."
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Ao falhar em uma validação.",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="name", type="array", items=@OA\Items()),
     *                  @OA\Property(property="email", type="array", items=@OA\Items()),
     *                  @OA\Property(property="pwd", type="array", items=@OA\Items()),
     *              )
     *          )
     *      )
     * )
     */
    public function create(UserRequest $request): JsonResponse
    {
        try {
            if (!empty(User::findByName($request->input("name"))) || !empty(User::findByEmail($request->input("email"))))
                return response()->json(null, Response::HTTP_CONFLICT);

            $user = new User([
                "name" => $request->input("name"),
                "email" => $request->input("email"),
                "password" => Hash::make($request->input("pwd"))
            ]);

            $user->save();

            return response()->json($user, Response::HTTP_CREATED);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *      path="/user",
     *      tags={"User"},
     *      summary="Editar usuário.",
     *      description="Edita um usuário.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="User Name"),
     *              @OA\Property(property="email", type="string", example="email@example.com"),
     *              @OA\Property(property="pwd", type="string", example="12345#qwert")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Usuário editado com sucesso.",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="User Name"),
     *              @OA\Property(property="email", type="string", example="email@example.com"),
     *              @OA\Property(property="updated_at", type="string", example="2022-11-14T00:06:03.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2022-11-14T00:06:03.000000Z"),
     *              @OA\Property(property="id", type="int", example="1")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Ao falhar na autorização.",
     *      ),
     *
     *      @OA\Response(
     *          response=409,
     *          description="Caso já exista um usuário com o mesmo nome e/ou e-mail."
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Ao falhar em uma validação.",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="name", type="array", items=@OA\Items()),
     *                  @OA\Property(property="email", type="array", items=@OA\Items()),
     *                  @OA\Property(property="pwd", type="array", items=@OA\Items()),
     *              )
     *          )
     *      )
     * )
     */
    public function edit(UserRequest $request): JsonResponse
    {
        try {
            $user = auth("sanctum")->user();

            $user->fill([
                "name" => $request->input("name"),
                "email" => $request->input("email"),
                "password" => Hash::make($request->input("pwd"))
            ]);

            $user->save();

            return response()->json($user);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete (
     *      path="/user",
     *      tags={"User"},
     *      summary="Remover usuário.",
     *      description="Remove o usuário.",
     *
     *      @OA\Response(
     *          response=200,
     *          description="Usuário removido com sucesso."
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Ao falhar na autorização.",
     *      ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Caso o usuário não exista.",
     *      )
     * )
     */
    public function destroy(): Response
    {
        try {
            $user = auth("sanctum")->user();

            if (empty($user))
                return response(null, Response::HTTP_NOT_FOUND);

            $user->delete();

            return response(null);
        } catch (Exception $e) {
            report($e);

            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
