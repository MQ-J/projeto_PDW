<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    private array $headers = [
        "Accept" => "json/application",
        "Authorization" => ""
    ];

    public function test_create_user(): void
    {
        $user = User::findByEmail("testeunit@teste.com");

        if (!empty($user))
            $user->forceDelete();

        $response = $this->post("/api/user", [
            "name" => "testeunit",
            "email" => "testeunit@teste.com",
            "pwd" => "12345"
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            "id",
            "name",
            "email",
            "updated_at",
            "created_at"
        ]);

        $user = User::findByEmail("testeunit@teste.com");
        $user->forceDelete();
    }

    public function test_edit_user(): void
    {
        $user = User::findByEmail("testeunit@teste.com");

        if (!empty($user))
            $user->forceDelete();

        $user = User::findByEmail("testeunit8@teste.com");

        if (!empty($user))
            $user->forceDelete();

        $user = new User([
            "name" => "testeunit",
            "email" => "testeunit@teste.com",
            "password" => Hash::make("12345")
        ]);

        $user->save();

        $response = $this->post("/api/auth", ["name" => "testeunit", "pwd" => "12345"]);
        $response->assertOk();

        $this->headers["Authorization"] = "Bearer " . $response->json("token");

        $response = $this->put("/api/user", [
            "name" => "testeunit54",
            "email" => "testeunit8@teste.com",
            "pwd" => "12345"
        ], $this->headers);

        $response->assertOk();
        $response->assertJsonStructure([
            "id",
            "name",
            "email",
            "updated_at",
            "created_at"
        ]);

        $this->assertEquals("testeunit54", $response->json("name"));
        $this->assertEquals("testeunit8@teste.com", $response->json("email"));

        $user->forceDelete();
    }

    public function test_delete_user(): void
    {
        $user = User::findByEmail("testeunit@teste.com");

        if (!empty($user))
            $user->forceDelete();

        $user = new User([
            "name" => "testeunit",
            "email" => "testeunit@teste.com",
            "password" => Hash::make("12345")
        ]);

        $user->save();

        $response = $this->post("/api/auth", ["name" => "testeunit", "pwd" => "12345"]);
        $response->assertOk();

        $this->headers["Authorization"] = "Bearer " . $response->json("token");

        $response = $this->delete("/api/user", [], $this->headers);
        $response->assertOk();

        $user->forceDelete();
    }
}
