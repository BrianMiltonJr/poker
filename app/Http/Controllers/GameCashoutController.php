<?php

namespace App\Http\Controllers;

use App\Models\Cashout;
use App\Models\Game;
use App\Models\Player;
use App\Rules\CashoutRule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameCashoutController extends Controller
{
    public function create(Request $request, Game $game)
    {
        return view('game.cashout.create')->with([
            'game' => $game,
            'players' => $game->getPlayers(),
        ]);
    }

    public function store(Request $request, Game $game)
    {
        $request->validate([
            'amounts' => ['required', new CashoutRule($game)],
        ]);

        $amounts = $request->get('amounts');
        DB::beginTransaction();
        foreach ($amounts as $playerId => $amount) {
            $player = Player::find($playerId);
            if (!$player) {
                DB::rollBack();
                return back()->withErrors('We could not find the players list. Changes have not been commited');
            }

            Cashout::create([
                'game_id' => $game->id,
                'player_id' => $player->id,
                'amount' => $amount,
            ]);
        }

        $game->end = Carbon::now();
        $game->save();

        DB::commit();
        return redirect()->route('game.show', $game)->with([
            'success' => "The game has been ended and all cashouts have been ran",
        ]);
    }
}
