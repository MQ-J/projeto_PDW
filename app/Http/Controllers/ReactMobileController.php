<?php

namespace App\Http\Controllers;

class ReactMobileController extends Controller
{

    public function login()
    {
        // busca o json atual e pôe em uma variável PHP
        $arquivo = __DIR__ . '/users.json';
        $users = json_decode(file_get_contents($arquivo))->users;

        //busca a requisição e pôe em uma variável PHP
        $post = json_decode('{
            "name":"'.$_POST['name'].'",
            "pwd":"'.$_POST['pwd'].'"
        }');

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
        // busca o json atual e pôe em uma variável PHP
        $arquivo = __DIR__ . '/users.json';
        $users = json_decode(file_get_contents($arquivo));

        //verifica se nome de usuário é inválido
        if (preg_match('/\W/', $_POST['name'])) {
            return response()->json([
                "status" => "Nok", 
                "message"=>"use apenas letras, numeros ou underline no nome de usuário"
            ]);
        }

        //Verifica se nome de usuário já existe
        foreach ($users->users as $user) {
            if($_POST['name'] == $user->name)
                return response()->json([
                    "status" => "Nok", 
                    "message"=>"Este usuário já existe"
                ]);
        }

        //busca a requisição e pôe em uma variável PHP
        $post = json_decode('{
            "name":"'.$_POST['name'].'",
            "pwd":"'.$_POST['pwd'].'"
        }');

        //adiciona novo usuário no array
        $users->users[] = $post;

        // altera o json com a array atualizada
        file_put_contents($arquivo, json_encode($users));

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
}
