<?php

namespace App\Http\Controllers;

use App\Models\Sllurp;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class SllurpController extends Controller
{
    /**
     * Guarda o corpo da requisição
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Manda as tags do slurp parra o projeto PHP
     *
     * @return \Illuminate\Http\Response
     */
    public function gettags()
    {
        // salva as tags
        $arquivo = __DIR__ . '/tags.json';
        file_put_contents($arquivo, json_encode($_POST));

        // devolve uma resposta de ok na tela
        return response()->json([
            'connection' => "OK",
            'message' => "tags enviadas com sucesso para o arquivo:",
            'file_path' => "app/Controllers/tags.json"
        ]);
    }
}