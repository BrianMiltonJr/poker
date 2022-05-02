<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameStoreRequest;
use App\Models\Game;
use App\View\Components\Input\Button;
use App\View\Components\Table;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $gamesTable = new Table(
            ['Game Date', 'Total Deposit'],
            Game::where('id', '>', 0),
            function ($game, $index) {
                $this->addAction(
                    $index,
                    'View',
                    route('game.show', $game),
                    'blue'
                );
                return [
                    'Game Date' => $game->start->format('l, jS F'),
                    'Total Deposit' => $game->getTotalDeposits(),
                ];
            }
        );

        return view('game.index')->with([
            'gamesTable' => $gamesTable
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('game.create');
    }

    public function show(Request $request, Game $game)
    {
        return view('game.show', compact('game'));
    }

    /**
     * @param \App\Http\Requests\GameStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GameStoreRequest $request)
    {
        $game = Game::create($request->validated());

        return redirect()->route('game.index');
    }
}
