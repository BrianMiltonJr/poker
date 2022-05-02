<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameStoreRequest;
use App\Models\Game;
use App\Models\Player;
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
                    'View Game',
                    route('game.show', $game)
                );
                return [
                    'Game Date' => $game->start->format('l, jS F'),
                    'Total Deposit' => $game->getTotalDeposits(),
                ];
            }
        );

        $gamesTable->addHeaderAction('Create Game', route('game.create'));

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
        $playerIds = $game->getPlayers()->pluck('id');
        $playersTable = new Table(
            ['Name', 'Deposits', 'Cashout', 'Difference'],
            Player::whereIn('id', $playerIds),
            function ($player, $index) use($game) {
                $stats = $player->getGameStats($game);

                $this->addAction($index, 'View Player', route('player.show', $player));

                return [
                    $player->name,
                    '$' . $stats['deposit'],
                    '$' . $stats['cashout'],
                    $game->end !== null ? '$' . $stats['difference'] : 'N/A',
                ];
            }
        );

        if (! $game->isFinished()) {
            $playersTable->addHeaderAction('Deposit Money', route('game.deposit.create', $game));
            $playersTable->addHeaderAction('End Game', route('game.cashout.create', $game));
        }
        
        return view('game.show')->with([
            'game' => $game,
            'playersTable' => $playersTable,
        ]);
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
