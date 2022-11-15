<?php

namespace App\Http\Controllers;

use App\Helpers\Permalink;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuController extends Controller
{
    /**
     * @OA\Get (
     *      path="/menu",
     *      tags={"Menu"},
     *      summary="Listar menus.",
     *      description="Lista os menus.",
     *
     *      @OA\Response(
     *          response=200,
     *          description="Menus lisitados com sucesso.",
     *
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="int", example="1"),
     *                  @OA\Property(property="user", type="int", example="1"),
     *                  @OA\Property(property="name", type="string", example="Novo Menu"),
     *                  @OA\Property(property="permalink", type="string", example="novo-menu"),
     *                  @OA\Property(property="updated_at", type="string", example="2022-11-14T00:06:03.000000Z"),
     *                  @OA\Property(property="created_at", type="string", example="2022-11-14T00:06:03.000000Z")
     *              )
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Ao falhar na autorização.",
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = auth("sanctum")->user();

            return response()->json(Menu::getByUserId($user->id));
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *      path="/menu",
     *      tags={"Menu"},
     *      summary="Criar menu.",
     *      description="Cria um novo menu.",
     *
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Novo Menu")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Menu criado com sucesso.",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Novo Menu"),
     *              @OA\Property(property="permalink", type="string", example="novo-menu"),
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
     *          description="Caso já exista um menu com o mesmo nome."
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Ao falhar em uma validação.",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="name", type="array", items=@OA\Items()),
     *              )
     *          )
     *      )
     * )
     */
    public function create(MenuRequest $request): JsonResponse
    {
        try {
            $user = auth("sanctum")->user();
            $name = $request->input("name");

            $permalink = Permalink::generatePermalink($name);
            $menu = Menu::findByPermalinkAndUser($permalink, $user->id);

            if (!empty($menu))
                return response()->json(null, Response::HTTP_CONFLICT);

            $menu = new Menu([
                "user" => $user->id,
                "name" => $name,
                "permalink" => $permalink
            ]);

            $menu->save();

            return response()->json($menu, Response::HTTP_CREATED);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *      path="/menu/:permalink",
     *      tags={"Menu"},
     *      summary="Editar usuário.",
     *      description="Edita um usuário.",
     *
     *      @OA\Parameter(
     *          name="permalink",
     *          description="Permalink do menu",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Novo Menu")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Menu editado com sucesso.",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Novo Menu"),
     *              @OA\Property(property="permalink", type="string", example="novo-menu"),
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
     *          description="Caso já exista um menu com o mesmo nome."
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Ao falhar em uma validação.",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="name", type="array", items=@OA\Items()),
     *              )
     *          )
     *      )
     * )
     */
    public function edit(MenuRequest $request, string $permalink): JsonResponse
    {
        try {
            $user = auth("sanctum")->user();
            $name = $request->input("name");

            $newPermalink = Permalink::generatePermalink($name);
            $menu = Menu::findByPermalinkAndUser($newPermalink, $user->id);

            if (!empty($menu))
                return response()->json(null, Response::HTTP_CONFLICT);

            $menu = Menu::findByPermalinkAndUser($permalink, $user->id);

            if (empty($menu))
                return $this->create($request);

            $menu->fill([
                "user" => $user->id,
                "name" => $name,
                "permalink" => $newPermalink
            ]);

            $menu->save();

            return response()->json($menu);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete (
     *      path="/menu/:permalink",
     *      tags={"Menu"},
     *      summary="Remover menu.",
     *      description="Remove o menu.",
     *
     *      @OA\Parameter(
     *          name="permalink",
     *          description="Permalink do menu",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Menu removido com sucesso."
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Ao falhar na autorização.",
     *      ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Caso o menu não exista.",
     *      )
     * )
     */
    public function destroy(Request $request, string $permalink): Response
    {
        try {
            $user = auth("sanctum")->user();

            if (empty($user))
                return response(null, Response::HTTP_FORBIDDEN);

            $menu = Menu::findByPermalinkAndUser($permalink, $user->id);

            if (empty($menu))
                return response(null, Response::HTTP_NOT_FOUND);

            $menu->delete();

            return response(null);
        } catch (Exception $e) {
            report($e);

            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
