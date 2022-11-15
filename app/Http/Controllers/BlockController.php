<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlockRequest;
use App\Models\Block;
use App\Models\Menu;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlockController extends Controller
{
    /**
     * @OA\Get (
     *      path="/menu/:permalink/block",
     *      tags={"Block"},
     *      summary="Listar blocos.",
     *      description="Lista os blocos dentro dos menus.",
     *
     *      @OA\Response(
     *          response=200,
     *          description="Blocos lisitados com sucesso.",
     *
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="int", example="1"),
     *                  @OA\Property(property="user", type="int", example="1"),
     *                  @OA\Property(property="menu", type="int", example="1"),
     *                  @OA\Property(property="text", type="string", example="Novo Bloco"),
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
    public function index(Request $request, string $permalink): JsonResponse
    {
        $user = auth("sanctum")->user();

        try {
            $menu = Menu::findByPermalinkAndUser($permalink, $user->id);
            $blocks = Block::getByUserAndMenu($user->id, $menu->id);

            return response()->json($blocks);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *      path="/menu/:permalink/block",
     *      tags={"Block"},
     *      summary="Criar bloco.",
     *      description="Cria um novo bloco.",
     *
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="text", type="string", example="Novo Bloco"),
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Menu criado com sucesso.",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="int", example="1"),
     *              @OA\Property(property="user", type="int", example="1"),
     *              @OA\Property(property="menu", type="int", example="1"),
     *              @OA\Property(property="text", type="string", example="Novo Bloco"),
     *              @OA\Property(property="updated_at", type="string", example="2022-11-14T00:06:03.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2022-11-14T00:06:03.000000Z")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Ao falhar na autorização.",
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Ao falhar em uma validação.",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="text", type="array", items=@OA\Items()),
     *              )
     *          )
     *      )
     * )
     */
    public function create(BlockRequest $request, string $permalink): JsonResponse
    {
        $user = auth("sanctum")->user();

        try {
            $menu = Menu::findByPermalinkAndUser($permalink, $user->id);

            $block = new Block([
                "user" => $user->id,
                "menu" => $menu->id,
                "text" => $request->input("text")
            ]);

            $block->save();

            return response()->json($block, Response::HTTP_CREATED);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *      path="/menu/:permalink/block/:id",
     *      tags={"Block"},
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
     *     @OA\Parameter(
     *          name="id",
     *          description="Id do bloco",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="int"
     *          )
     *      ),
     *
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="text", type="string", example="Novo Bloco"),
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Menu criado com sucesso.",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="int", example="1"),
     *              @OA\Property(property="user", type="int", example="1"),
     *              @OA\Property(property="menu", type="int", example="1"),
     *              @OA\Property(property="text", type="string", example="Novo Bloco"),
     *              @OA\Property(property="updated_at", type="string", example="2022-11-14T00:06:03.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2022-11-14T00:06:03.000000Z")
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
     *                  @OA\Property(property="text", type="array", items=@OA\Items()),
     *              )
     *          )
     *      )
     * )
     */
    public function edit(BlockRequest $request, string $permalink, int $id): JsonResponse
    {
        $user = auth("sanctum")->user();

        try {
            $menu = Menu::findByPermalinkAndUser($permalink, $user->id);
            $block = Block::findById($id);

            if (empty($block))
                return $this->create($request);

            $block->fill([
                "menu" => $menu->id,
                "text" => $request->input("text")
            ]);

            $block->save();

            return response()->json($block);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete (
     *      path="/menu/:permalink/block/:id",
     *      tags={"Block"},
     *      summary="Remover bloco.",
     *      description="Remove o bloco.",
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
     *     @OA\Parameter(
     *          name="id",
     *          description="Id do bloco",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="int"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Bloco removido com sucesso."
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
    public function destroy(Request $request, string $permalink, int $id): Response
    {
        $user = auth("sanctum")->user();

        try {
            $block = Block::findByUserAndId($user->id, $id);

            if (empty($block))
                return response(null, Response::HTTP_NOT_FOUND);

            $block->delete();

            return response(null);
        } catch (Exception $e) {
            report($e);

            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
