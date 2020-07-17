<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class RegisterApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_新しいユーザーを作成して返却する()
    {
        $data = [
            'name' => 'user',
            'email' => 'test@email.com',
            'password' => 'test1234!',
            'password_confirmation' => 'test1234!',
        ];

        $response = $this->json('POST', route('register'), $data);

        $user = User::first();
        $this->assertEquals(
            [$data['name'], $data['email']],
            [$user->name, $user->email]
        );
        $this->assertNotEquals(
            $data['password'],
            $user->password
        );

        $response->assertStatus(201)
            ->assertJson([
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }
}
