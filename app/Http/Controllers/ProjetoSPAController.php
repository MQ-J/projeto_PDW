<?php

namespace App\Http\Controllers;


class ProjetoSPAController extends Controller
{
    public function sendFeedback() {

        // busca o json atual e pôe em uma array
        $arquivo = __DIR__ . '/feedback.json';
        $feedbacks = json_decode(file_get_contents($arquivo));

        // adiciona o feedback encontrado na array
        $feedbacks[] = $_POST;

        // altera o json com a array atualizada
        file_put_contents($arquivo, json_encode($feedbacks));

        // devolve uma resposta de ok na tela
        return response()->json([
            'connection' => "OK",
            'feedbacks' => $feedbacks,
        ]);
    }

    public function getFeedbacks() {

        // busca o json atual e pôe em uma array
        $arquivo = __DIR__ . '/feedback.json';
        $feedbacks = json_decode(file_get_contents($arquivo));

        // devolve uma resposta de ok na tela
        return response()->json([
            'connection' => "OK",
            'feedbacks' => $feedbacks,
        ]);
    }
}