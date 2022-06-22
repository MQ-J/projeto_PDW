<?php

namespace App\Http\Controllers;


class SllurpController extends Controller
{

    public function getconnection()
    {
        // salva os detalhes da conexão em um json
        $arquivo = __DIR__ . '/connection.json';
        file_put_contents($arquivo, json_encode($_SERVER));

        // devolve uma resposta de ok na tela
        return response()->json([
            'connection' => "OK",
            'message' => "Requisicao lida com sucesso, 
                            e salva em arquivo JSON",
            'file_path' => "app/Controllers/connection.json"
        ]);
    }

    
    public function gettags()
    {
        // busca o json atual e pôe em uma array
        $arquivo = __DIR__ . '/tags.json';
        $TAGS = json_decode(file_get_contents($arquivo));

        // adiciona a tag encontrada na array
        $TAGS[] = $_POST;

        // altera o json com a array atualizada
        file_put_contents($arquivo, json_encode($TAGS));

        // devolve uma resposta de ok na tela
        return response()->json([
            'connection' => "OK",
            'message' => "tags enviadas com sucesso para o arquivo:",
            'file_path' => "app/Controllers/tags.json"
        ]);
    }
}