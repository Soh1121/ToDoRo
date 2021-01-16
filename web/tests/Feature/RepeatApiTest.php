<?php

namespace Tests\Feature;

use App\Repeat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepeatApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_繰り返し一覧を取得できる()
    {
        $response = $this
            ->json('GET',
                route('repeat')
        );

        $response->assertStatus(200);
    }
}
