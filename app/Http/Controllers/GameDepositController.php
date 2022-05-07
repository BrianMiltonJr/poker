<?php

namespace App\Http\Controllers;

use App\Models\ChipHandout;
use App\Models\Deposit;
use App\Models\Game;
use App\Models\Player;
use App\Rules\CashSchema;
use App\View\Components\Input\Select;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $input = $request->all();
        $input['depositSchema'] = json_decode($input['depositSchema'], true);

        $validator = Validator::make($input, [
            'player' => 'required|exists:players,id',
            'depositSchema' => ['required', new CashSchema()],
        ]);

        $validated = $validator->validated();

        $player = Player::find($validated['player']);
        $denominations = [];
        foreach ($validated['depositSchema'] as $key => $value) {
            if ($key === "chips-to-handout") {
                continue;
            }
            if ($value > 0) {
                $denominations[$key] = $value;
            }
        }
        
        $chipsToHandout = $validated['depositSchema']['chips-to-handout'];

        $total = 0;
        foreach ($denominations as $denomination => $amount) {
            $total += floatval($denomination) * $amount;
        }

        DB::beginTransaction();
        $deposit = Deposit::create([
            'game_id' => $game->id,
            'player_id' => $player->id,
            'amount' => $total,
            'schema' => json_encode($denominations),
        ]);

        foreach ($chipsToHandout as $color => $amount) {
            $chipType = $game->chipTypes()->where('color', $color)->first();
            ChipHandout::create([
                'chip_id' => $chipType->id,
                'deposit_id' => $deposit->id,
                'amount' => $amount,
            ]);
        }

        DB::commit();

        return redirect()->route('game.show', $game)->with([
            'success' => "{$player->name} has deposited {$deposit->amount} into the game",
        ]);
    }
}
