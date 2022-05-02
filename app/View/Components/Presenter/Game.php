<?php

namespace App\View\Components\Presenter;

use App\Models\Game as ModelsGame;
use Exception;
use Illuminate\View\Component;

class Game extends Component
{

    public ModelsGame $game;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $gameId)
    {
        $this->game = ModelsGame::find($gameId);
        if (! $this->game) {
            throw new Exception("We could not find game by id {$this->game->id}");
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.presenter.game');
    }
}
