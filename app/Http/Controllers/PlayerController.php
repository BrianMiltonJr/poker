<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerStoreRequest;
use App\Models\Game;
use App\Models\Player;
use App\View\Components\Table;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $players = Player::all();

        return view('player.index', compact('players'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('player.create');
    }

    public function show(Request $request, Player $player)
    {
        $gameIds = $player->deposits()->distinct()->pluck('game_id');

        $playerTable = new Table(
            ['Game', 'Deposited', 'Cashed Out'],
            Game::whereIn('id', $gameIds),
            function ($game, $index) {
                $this->addAction($index, 'View', route('game.show', $game));

                return [
                    $game->getTableView(),
                    $game->getTotalDeposits(),
                    $game->getTotalCashouts(),
                ];
            }
        );

        return view('player.show')->with([
            'playerTable' => $playerTable,
            'player' => $player,
        ]);
    }

    /**
     * @param \App\Http\Requests\PlayerStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlayerStoreRequest $request)
    {
        $player = Player::create($request->validated());

        return redirect()->route('player.index');
    }
}
