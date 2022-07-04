<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{
    public function index() {
        User::factory(10)->create();
        User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        return response()->json([
            'connection' => "OK"
        ]);
    }
}
