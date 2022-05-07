<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameStoreRequest;
use App\Models\Chip;
use App\Models\Game;
use App\Models\Player;
use App\Rules\ChipSchema;
use App\View\Components\Input\Button;
use App\View\Components\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                    $game->start->format('l, jS F'),
                    $game->getTotalDeposits(),
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
        $data = $request->all();
        $data['chip_schema'] = json_decode($data['chip_schema'], true);

        $validator = Validator::make($data, [
            'start' => 'required',
            'chip_schema' => ['required', new ChipSchema()]
        ]);

        $validated = $validator->validated();

        $game = Game::create([
            'start' => $validated['start'],
        ]);

        foreach ($validated['chip_schema'] as $chip) {
            Chip::create([
                'game_id' => $game->id,
                ...$chip,
            ]);
        }

        return redirect()->route('game.index');
    }
}
