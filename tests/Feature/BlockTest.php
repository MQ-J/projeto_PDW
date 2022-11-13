<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class BlockTest extends TestCase
{
    private User $user;
    private Menu $menu;
    private array $headers = [
        "Accept" => "json/application",
        "Authorization" => ""
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::findByEmail("testeunit@teste.com");

        if (!empty($user))
            $user->forceDelete();

        $this->user = new User([
            "name" => "testeunit",
            "email" => "testeunit@teste.com",
            "password" => Hash::make("12345")
        ]);

        $this->user->save();

        $this->menu = new Menu([
            "user" => $this->user->id,
            "name" => "Teste Menu",
            "permalink" => "teste-menu"
        ]);

        $this->menu->save();
    }

    public function test_create_block(): void
    {
        $response = $this->post("/api/auth", [
            "name" => "testeunit",
            "pwd" => "12345"
        ]);

        $response->assertOk();
        $token = $response->json("token");

        $this->headers["Authorization"] = "Bearer " . $token;

        $response = $this->post("/api/menu/teste-menu/block", ["text" => "Olá mundo"], $this->headers);

        $response->assertCreated();
        $response->assertJsonStructure([
            "id",
            "user",
            "menu",
            "text",
            "updated_at",
            "created_at"
        ]);

        $token = preg_replace("/\d+\|/mi", "", $token);

        $personalToken = PersonalAccessToken::findToken($token);
        $personalToken->forceDelete();
    }

    protected function tearDown(): void
    {
        $this->user->forceDelete();
        $this->menu->forceDelete();
        parent::tearDown();
    }
}
