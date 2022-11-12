<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private User $user;

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
    }

    public function test_token_creation(): void
    {
        $response = $this->post("/api/auth", [
            "name" => "testeunit",
            "pwd" => "12345"
        ]);

        $response->assertOk();
        $response->assertJsonStructure(["token"]);
    }

    public function test_revoke_token(): void
    {
        $response = $this->delete("/api/auth");

        $response->assertOk();
    }

    protected function tearDown(): void
    {
        $this->user->forceDelete();
        parent::tearDown();
    }
}
