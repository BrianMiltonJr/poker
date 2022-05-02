<?php

use App\Models\Deposit;
use App\Models\Game;
use App\Models\Player;

beforeEach(function () {
    Deposit::factory()->create();
    Game::factory()->create();
    Player::factory()->create();
});

it('has deposits')->assertDatabaseHas('deposits', [
    'id' => 1
]);

it('can store a deposit', function () {
    $game = Game::find(1);
    $this->call('POST', route('game.deposit.store', $game), [
        '_token' => csrf_token(),
        'player' => Player::find(1)->id,
        'amount' => 200
    ])->assertRedirect(route('game.show', $game));
});
