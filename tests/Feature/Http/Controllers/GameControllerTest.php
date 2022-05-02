<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GameController
 */
class GameControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $games = Game::factory()->count(3)->create();

        $response = $this->get(route('game.index'));

        $response->assertOk();
        $response->assertViewIs('game.index');
        $response->assertViewHas('games');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('game.create'));

        $response->assertOk();
        $response->assertViewIs('game.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GameController::class,
            'store',
            \App\Http\Requests\GameStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $start = $this->faker->dateTime();

        $response = $this->post(route('game.store'), [
            'start' => $start,
        ]);

        $games = Game::query()
            ->where('start', $start)
            ->get();
        $this->assertCount(1, $games);
        $game = $games->first();

        $response->assertRedirect(route('game.index'));
    }
}
