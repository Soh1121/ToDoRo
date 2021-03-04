<?php

namespace Tests\Feature;

use App\Repeat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepeatApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void{
        parent::setUp();

        $this->seed('RepeatsTableSeeder');
    }

    /**
     * @test
     */
    public function should_繰り返し一覧を取得できる()
    {
        $response = $this
            ->json('GET',
                route('repeat')
        );

        $repeats = Repeat::get();
        $repeats = $repeats->map(function($repeat) {
            return [
                'id' => $repeat->id,
                'name' => $repeat->name,
            ];
        })->all();

        $response->assertStatus(200)
            ->assertJsonFragment(([
                'data' => $repeats,
            ]
        ));
    }
}
