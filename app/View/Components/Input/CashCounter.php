<?php

namespace App\View\Components\Input;

use App\Models\Game;
use Illuminate\View\Component;

class CashCounter extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Game $game)
    {
        $chipTypes = $game->chipTypes->mapWithKeys(function ($chip, $key) {
            return [
                $chip->id => [
                    'color' => $chip->color,
                    'denomination' => $chip->denomination,
                    'amount' =>  $chip->amount,
                ],
            ];
        })->toArray();

        $cashHandouts = $game->deposits->map(function ($deposit) {
            return $deposit->chipHandouts;
        });

        foreach ($cashHandouts as $cashHandout) {
            foreach ($cashHandout as $handout) {
                $chipTypes[$handout->chip_id]['amount'] -= $handout->amount;
            }
        }

        $this->chipTypes = json_encode($chipTypes);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.cash-counter')->with([
            'chipAmounts' => $this->chipTypes,
        ]);
    }
}
