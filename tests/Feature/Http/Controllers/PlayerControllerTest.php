<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PlayerController
 */
class PlayerControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $players = Player::factory()->count(3)->create();

        $response = $this->get(route('player.index'));

        $response->assertOk();
        $response->assertViewIs('player.index');
        $response->assertViewHas('players');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('player.create'));

        $response->assertOk();
        $response->assertViewIs('player.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PlayerController::class,
            'store',
            \App\Http\Requests\PlayerStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $name = $this->faker->name;

        $response = $this->post(route('player.store'), [
            'name' => $name,
        ]);

        $players = Player::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $players);
        $player = $players->first();

        $response->assertRedirect(route('player.index'));
    }
}
