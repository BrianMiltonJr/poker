<?php

use App\Models\Game;
use Carbon\Carbon;

beforeEach(fn () => Game::factory()->create());

it('has games')->assertDatabaseHas('games', [
    'id' => 1
]);

it('has an index', function () {
    $response = $this->get(route('game.index'));

    $response->assertStatus(200);
});

it('can display a game', function () {
    $game = Game::find(1);
    $reponse = $this->get(route('game.show', $game));

    $reponse->assertStatus(200);
});

it('can store a game', function () {
    $this->call('POST', route('game.store'), [
        '_token' => csrf_token(),
        'start' => Carbon::now(),
    ])->assertRedirect(route('game.index'));
});
