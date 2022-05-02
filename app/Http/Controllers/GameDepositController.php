<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Game;
use App\Models\Player;
use App\View\Components\Input\Select;
use Illuminate\Http\Request;

class GameDepositController extends Controller
{
    public function create(Request $request, Game $game)
    {
        return view('game.deposit.create')->with([
            'game' => $game,
            'playerSelect' => new Select(
                Player::all()->map(function ($player) {
                    return [
                        'value' => $player->id,
                        'title' => $player->name,
                    ];
                })->toArray(),
                'player',
                'Player'
            ),
        ]);
    }

    public function store(Request $request, Game $game)
    {
        $request->validate([
            'player' => 'required|exists:players,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $player = Player::find($request->player);
        $deposit = Deposit::create([
            'game_id' => $game->id,
            'player_id' => $player->id,
            'amount' => $request->get('amount')
        ]);

        return redirect()->route('game.show', $game)->with([
            'success' => "{$player->name} has deposited {$deposit->amount} into the game",
        ]);
    }
}
