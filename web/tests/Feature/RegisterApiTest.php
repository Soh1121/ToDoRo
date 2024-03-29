<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use App\Project;
use App\Context;

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
            'password' => 'te-st_12',
            'password_confirmation' => 'te-st_12',
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

    /**
     * @test
     */
    public function should_ユーザー名は255文字までOK()
    {
        $data = [
            'name' => str_repeat("a", 255),
            'email' => 'test@email.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ];

        $response = $this->json('POST', route('register'), $data);
        $user = User::first();

        $response->assertStatus(201)
            ->assertJson([
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }

    /**
     * @test
     */
    public function should_ユーザー名は256文字だとNG()
    {
        $data = [
            'name' => str_repeat("a", 256),
            'email' => 'test@email.com',
            'password' => 'test1234!',
            'password_confirmation' => 'test1234!',
        ];

        $response = $this->json('POST', route('register'), $data);
        $user = User::first();

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_ユーザー名は空だとNG()
    {
        $data = [
            'user' => '',
            'email' => 'test@email.com',
            'password' => 'test1234!',
            'password_confirmation' => 'test1234!',
        ];

        $response = $this->json('POST', route('register'), $data);
        $user = User::first();

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_メールアドレスはアットマークがないとNG()
    {
        $data = [
            'user' => 'test',
            'email' => 'testemail.com',
            'password' => 'test1234!',
            'password_confirmation' => 'test1234!',
        ];

        $response = $this->json('POST', route('register'), $data);
        $user = User::first();

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_メールアドレスはアットマークだけだとNG()
    {
        $data = [
            'user' => 'test',
            'email' => '@',
            'password' => 'test1234!',
            'password_confirmation' => 'test1234!',
        ];

        $response = $this->json('POST', route('register'), $data);
        $user = User::first();

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_メールアドレスはアットマークが2個以上だとNG()
    {
        $data = [
            'user' => 'test',
            'email' => 'test@example@com',
            'password' => 'test1234!',
            'password_confirmation' => 'test1234!',
        ];

        $response = $this->json('POST', route('register'), $data);
        $user = User::first();

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_すでにメールアドレスが登録済みだとNG()
    {
        $data = [
            'name' => 'user',
            'email' => 'test@email.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ];

        $response = $this->json('POST', route('register'), $data);

        $user = User::first();

        $response->assertStatus(201)
            ->assertJson([
                'name' => $user->name,
                'email' => $user->email,
            ]);

        $response = $this->json('POST', route('register'), $data);

        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function should_パスワードが7文字はNG()
    {
        $data = [
            'user' => 'test',
            'email' => 'test@example.com',
            'password' => 'test123',
            'password_confirmation' => 'test123',
        ];

        $response = $this->json('POST', route('register'), $data);
        $user = User::first();

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_パスワードに日本語はNG()
    {
        $data = [
            'user' => 'test',
            'email' => 'test@example.com',
            'password' => 'てすとてすとてすと',
            'password_confirmation' => 'てすとてすとてすと',
        ];

        $response = $this->json('POST', route('register'), $data);
        $user = User::first();

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_パスワードにハイフン、アンダーバー以外の記号はNG()
    {
        $data = [
            'user' => 'test',
            'email' => 'test@example.com',
            'password' => 'te!st!12',
            'password_confirmation' => 'te!st!12',
        ];

        $response = $this->json('POST', route('register'), $data);
        $user = User::first();

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_パスワードと確認が不一致だとNG()
    {
        $data = [
            'user' => 'test',
            'email' => 'test@example.com',
            'password' => 'test1234',
            'password_confirmation' => 'test12345',
        ];

        $response = $this->json('POST', route('register'), $data);
        $user = User::first();

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_パスワードが空だとNG()
    {
        $data = [
            'user' => 'test',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ];

        $response = $this->json('POST', route('register'), $data);
        $user = User::first();

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_ユーザー登録すると未設定プロジェクトが作成される()
    {
        $data = [
            'name' => 'user',
            'email' => 'test@email.com',
            'password' => 'te-st_12',
            'password_confirmation' => 'te-st_12',
        ];

        $response = $this->json('POST', route('register'), $data);

        $user = User::first();
        $project = Project::where('user_id', $user->id)
            ->orderBy(Project::CREATED_AT, 'desc')
            ->first();

        $response->assertStatus(201);
        $this->assertEquals(
            $project->name, '未設定'
        );
    }

    /**
     * @test
     */
    public function should_ユーザー登録すると未設定コンテキストが作成される()
    {
        $data = [
            'name' => 'user',
            'email' => 'test@email.com',
            'password' => 'te-st_12',
            'password_confirmation' => 'te-st_12',
        ];

        $response = $this->json('POST', route('register'), $data);

        $user = User::first();
        $context = Context::where('user_id', $user->id)
            ->orderBy(Context::CREATED_AT, 'desc')
            ->first();

        $response->assertStatus(201);
        $this->assertEquals(
            $context->name, '未設定'
        );
    }
}
