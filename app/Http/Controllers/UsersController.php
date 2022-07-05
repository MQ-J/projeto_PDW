<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{
    public function index() {

        $users = User::all(['name', 'email']);

        return response()->json([
            'connection' => "OK",
            'data' => $users
        ]);
    }

    public function create() {

        User::create([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['pwd']
        ]);

        return response()->json([
            "status" => "ok", 
            "message"=> "usuário $_POST[name] criado com sucesso!"
        ]);
    }
}
