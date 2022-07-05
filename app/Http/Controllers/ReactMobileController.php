<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReactMobileController extends Controller
{

    public function login()
    {
        $user = DB::table('users')
            ->where('name', $_POST['name'])
            ->where('password', $_POST['pwd'])
        ->first();

        if ($user)
            return response()->json(["status" => "ok", "menu" => $user->menu]);

        return response()->json(["status" => "Nok"]);
    }

    public function newUser()
    {
        //verifica se nome de usuário é inválido
        if (preg_match('/\W/', $_POST['name'])) {
            return response()->json([
                "status" => "Nok", 
                "message"=>"use apenas letras sem acento, numeros ou underline no nome de usuário"
            ]);
        }

        // verifica se usuário já existe
        if(DB::table('users')->where('name', $_POST['name'])->first()) {
            return response()->json([
                "status" => "Nok", 
                "message"=>"Este usuário já existe"
            ]);
        }

        // tenta criar o usuário
        try {
            User::create([
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['pwd']
            ]);

        } catch(\Illuminate\Database\QueryException $ex){

            return response()->json([
                "status" => "Nok", 
                "message"=> $ex->getMessage()
            ]);
        }

        // retorna mensagem ok
        return response()->json([
            "status" => "ok", 
            "message"=> "usuário $_POST[name] criado com sucesso!"
        ]);
        
    }

    public function deleteUser() /* EU PAREI AQUI */
    {
        // busca o json atual e pôe em uma array associativa
        $arquivo = __DIR__ . '/users.json';
        $users = json_decode(file_get_contents($arquivo), true);

        //busca a requisição e pôe em uma array associativa
        $post = json_decode('{
            "name":"'.$_POST['name'].'",
            "pwd":"'.$_POST['pwd'].'"
        }', true);

        //verifica se o usuário existe, paga apaga-lo
        foreach ($users as $key => $user) {
            if($post == $user){

                unset($users[$key]);

                // altera o json com a array atualizada
                file_put_contents($arquivo, json_encode($users));

                return response()->json([
                    "status" => "ok",
                    "message"=> "usuário $_POST[name] apagado com sucesso!"
                ]);
            }
        }

        // se não tiver nenhum igual, retorna erro
        return response()->json([
            "status" => "Nok",
            "message"=> "usuário $_POST[name] não encontrado!"
        ]);
    }

    // public function addMenu() {

    // }
}
