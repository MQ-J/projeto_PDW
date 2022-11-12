<?php

namespace App\Http\Controllers;

use App\Helpers\Permalink;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;


class MenuController extends Controller
{
    public function create(MenuRequest $request): JsonResponse
    {
        try {
            $user = $request->input("user");
            $permalink = Permalink::generatePermalink($request->input("name"));
            $menu = Menu::findByPermalinkAndUser($permalink, (int)$user);

            if (!empty($menu))
                return response()->json(null, Response::HTTP_CONFLICT);

            $menu = new Menu([
                "user" => $user,
                "name" => $request->input("name"),
                "permalink" => $permalink
            ]);

            $menu->save();

            return response()->json($menu, Response::HTTP_CREATED);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(MenuRequest $request, string $permalink): JsonResponse
    {
        try {
            $user = $request->input("user");
            $name = $request->input("name");

            $newPermalink = Permalink::generatePermalink($name);
            $menu = Menu::findByPermalinkAndUser($newPermalink, (int)$user);

            if (!empty($menu))
                return response()->json(null, Response::HTTP_CONFLICT);

            $menu = Menu::findByPermalinkAndUser($permalink, (int)$user);

            if (empty($menu))
                return $this->create($request);

            $menu->fill([
                "user" => $user,
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
