<?php

namespace Tests\Feature;

use App\Priority;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PriorityApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();

        $this->seed('PrioritiesTableSeeder');
    }

    /**
     * @test
     */
    public function should_優先度一覧を取得できる()
    {
        $response = $this
            ->json('GET',
                route('priority')
            );

        $response->assertStatus(200);
    }
}
