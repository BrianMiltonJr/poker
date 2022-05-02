<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Cashout;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CashoutController
 */
class CashoutControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $cashouts = Cashout::factory()->count(3)->create();

        $response = $this->get(route('cashout.index'));

        $response->assertOk();
        $response->assertViewIs('cashout.index');
        $response->assertViewHas('cashouts');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('cashout.create'));

        $response->assertOk();
        $response->assertViewIs('cashout.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CashoutController::class,
            'store',
            \App\Http\Requests\CashoutStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $amount = $this->faker->randomFloat(/** decimal_attributes **/);
        $game = Game::factory()->create();
        $player = Player::factory()->create();

        $response = $this->post(route('cashout.store'), [
            'amount' => $amount,
            'game_id' => $game->id,
            'player_id' => $player->id,
        ]);

        $cashouts = Cashout::query()
            ->where('amount', $amount)
            ->where('game_id', $game->id)
            ->where('player_id', $player->id)
            ->get();
        $this->assertCount(1, $cashouts);
        $cashout = $cashouts->first();

        $response->assertRedirect(route('cashout.index'));
    }
}
