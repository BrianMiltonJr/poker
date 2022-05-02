<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerStoreRequest;
use App\Models\Player;
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
        return view('player.show', compact('player'));
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
