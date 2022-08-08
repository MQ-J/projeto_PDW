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

        if ($user) {

            $menus = DB::table('menus')
                ->where('id', $user->id)
            ->get();

            return response()->json(["status" => "ok", "email" => $user->email, "menus" => $menus]);
        }

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

        try {

            // tenta criar o usuário
            User::create([
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['pwd']
            ]);

            //inicia menu para usuário
            $user = DB::table('users')
                ->where('name', $_POST['name'])
            ->update(['menu' => 'tarefas']);

            //cria bloco e menu para usuário
            $user = DB::table('users')
                ->where('name', $_POST['name'])
            ->first();
            DB::table('menus')->insert([
                'id' => $user->id,
                'nome' => 'tarefas'
            ]);
            DB::table('blocos')->insert([
                'id' => $user->id,
                'title' => 'EXEMPLO',
                'text' =>  'escreva coisas aqui, e salve. Vai ficar salvo pra quando vc precisar.',
                'code' => 'imvr9qdle',
                'menu' => 'tarefas'
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

    public function deleteUser()
    {
        $user = DB::table('users')
            ->where('name', $_POST['name'])
        ->first();

        $blocos = DB::table('blocos')
            ->where('id', $user->id)
        ->delete();

        $deleted = DB::table('users')
            ->where('name', $_POST['name'])
        ->delete();

        if ($deleted)
            return response()->json(["status" => "ok"]);

        return response()->json(["status" => "Nok"]);
    }

    public function getBlocos()
    {
        $user = DB::table('users')
            ->where('name', $_POST['name'])
        ->first();
        
        $blocos = DB::table('blocos')
            ->where('id', $user->id)
            ->where('menu', $_POST['menu'])
        ->get();

        if ($blocos)
            return response()->json(["status" => "ok", "blocos" => $blocos]);

        return response()->json(["status" => "Nok"]);
    }

    public function updateBlocos()
    {
        //pesquisa o usuário
        $user = DB::table('users')
            ->where('name', $_POST['name'])
        ->first();
        
        //usa o id do usuário para tentar localizar o bloco referente
        $blocos = DB::table('blocos')
            ->where('id', $user->id)
            ->where('code', $_POST['code'])
        ->get();

        //se o bloco existir, edita-o
        $blocos = DB::table('blocos')
            ->where('id', $user->id)
            ->where('code', $_POST['code'])
        ->update(['title' => $_POST['title'], 'text' =>  $_POST['text']]);
        if($blocos != 0) {
            return response()->json(["status" => "ok", "blocos" => $blocos]);
        }
     
        //se o bloco não existir, cria-o
        else {

            try {
                DB::table('blocos')->insert([
                    'id' => $user->id,
                    'title' => $_POST['title'],
                    'text' =>  $_POST['text'],
                    'code' => $_POST['code'],
                    'menu' => $_POST['menu']
                ]);
    
            } catch(\Illuminate\Database\QueryException $ex){
    
                return response()->json([
                    "status" => "Nok", 
                    "message"=> $ex->getMessage()
                ]);
            }

            return response()->json(["status" => "ok"]);
        }
    }

    public function deleteBloco()
    {
        $user = DB::table('users')
            ->where('name', $_POST['name'])
        ->first();

        $blocos = DB::table('blocos')
            ->where('id', $user->id)
            ->where('code', $_POST['code'])
        ->delete();

        return response()->json(["status" => "ok"]);
    }

    public function newMenu()
    {
        //pesquisa o usuário
        $user = DB::table('users')
            ->where('name', $_POST['user'])
        ->first();

        try {
            DB::table('menus')->insert([
                'id' => $user->id,
                'nome' => $_POST['nome'],
                'code' => $_POST['code']
            ]);
            DB::table('blocos')->insert([
                'id' => $user->id,
                'title' => 'EXEMPLO',
                'text' =>  'escreva coisas aqui, e salve. Vai ficar salvo pra quando vc precisar.',
                'code' => 'imvr9qdle',
                'menu' => $_POST['nome'],
                'codemenu' => $_POST['code']
            ]);

        } catch(\Illuminate\Database\QueryException $ex){

            return response()->json([
                "status" => "Nok", 
                "message"=> $ex->getMessage()
            ]);
        }

        return response()->json(["status" => "ok"]);
        
    }

}
