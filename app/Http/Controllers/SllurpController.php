<?php

namespace App\Http\Controllers;

use App\Models\Sllurp;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class SllurpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getconnection()
    {
        // mostra os detalhes da conexão
        // print_r($_SERVER);

        // salva os detalhes da conexão em um json
        $arquivo = __DIR__ . '/connection.json';
        file_put_contents($arquivo, json_encode($_POST));

        // devolve uma resposta de ok na tela
        return response()->json([
            'connection' => "OK",
            'message' => "Requisicao lida com sucesso, 
                            e salva em arquivo JSON",
            'file_path' => "app/Controllers/connection.json"
        ]);
    }
}