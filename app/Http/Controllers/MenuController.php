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
}
