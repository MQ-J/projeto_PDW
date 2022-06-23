<?php

namespace App\Http\Controllers;

class ReactMobileController extends Controller
{
    
    public function getUsers()
    {

        $arquivo = __DIR__ . '/users.json';
        $users = json_decode(file_get_contents($arquivo));
        
        return response()->json($users);
    }

    public function login()
    {
        // busca o json atual e pôe em uma array associativa
        $arquivo = __DIR__ . '/users.json';
        $users = json_decode(file_get_contents($arquivo), true)['users'];

        //busca a requisição e pôe em uma array associativa
        $post = json_decode('{
            "name":"'.$_POST['name'].'",
            "pwd":"'.$_POST['pwd'].'"
        }', true);

        //para cada usuário cadastrado, verifica se bate com a requisição
        foreach ($users as $user) {
            if($post == $user)
                return response()->json(["status" => "ok"]);
        }

        // se não tiver nenhum igual, retorna erro
        return response()->json(["status" => "Nok", "post"=> $post]);
    }

    public function newUser()
    {
        // busca o json atual e pôe em uma array associativa
        $arquivo = __DIR__ . '/users.json';
        $users = json_decode(file_get_contents($arquivo), true);

        //busca a requisição e pôe em uma array associativa
        $post = json_decode('{
            "name":"'.$_POST['name'].'",
            "pwd":"'.$_POST['pwd'].'"
        }', true);

        //adiciona novo usuário na lista
        $users['users'][] = $post;

        // altera o json com a array atualizada
        file_put_contents($arquivo, json_encode($users));

        // se não tiver nenhum igual, retorna erro
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
}
