<?php

namespace App\Http\Controllers;

class ReactMobileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsers()
    {

        $arquivo = __DIR__ . '/users.json';
        $users = file_get_contents($arquivo);
        
        return response()->json($users);
    }
}
