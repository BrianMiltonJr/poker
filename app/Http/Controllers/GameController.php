<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameStoreRequest;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $games = Game::all();

        return view('game.index', compact('games'));
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
