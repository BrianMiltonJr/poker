<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Deposit;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DepositController
 */
class DepositControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $deposits = Deposit::factory()->count(3)->create();

        $response = $this->get(route('deposit.index'));

        $response->assertOk();
        $response->assertViewIs('deposit.index');
        $response->assertViewHas('desposits');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('deposit.create'));

        $response->assertOk();
        $response->assertViewIs('deposit.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DepositController::class,
            'store',
            \App\Http\Requests\DepositStoreRequest::class
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

        $response = $this->post(route('deposit.store'), [
            'amount' => $amount,
            'game_id' => $game->id,
            'player_id' => $player->id,
        ]);

        $deposits = Deposit::query()
            ->where('amount', $amount)
            ->where('game_id', $game->id)
            ->where('player_id', $player->id)
            ->get();
        $this->assertCount(1, $deposits);
        $deposit = $deposits->first();

        $response->assertRedirect(route('deposit.index'));
    }
}
