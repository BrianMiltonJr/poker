<?php

use App\Models\Player;


beforeEach(fn () => Player::factory()->create());

it('has players')->assertDatabaseHas('players', [
    'id' => 1
]);

it('has an index', function () {
    $response = $this->get(route('player.index'));

    $response->assertStatus(200);
});

it('can display a player', function () {
    $player = Player::find(1);
    $reponse = $this->get(route('player.show', $player));

    $reponse->assertStatus(200);
});

it('can store a player', function () {
    $this->call('POST', route('player.store'), [
        '_token' => csrf_token(),
        'name' => \Str::random(10),
    ])->assertRedirect(route('player.index'));
});
