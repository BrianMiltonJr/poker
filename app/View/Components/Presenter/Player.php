<?php

namespace App\View\Components\Presenter;

use App\Models\Player as ModelsPlayer;
use Exception;
use Illuminate\View\Component;

class Player extends Component
{

    public ModelsPlayer $player;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $playerId)
    {
        $this->player = ModelsPlayer::find($playerId);
        if (! $this->player) {
            throw new Exception("Could not find player by id {$playerId}");
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.presenter.player');
    }
}
