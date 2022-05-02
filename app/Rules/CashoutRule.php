<?php

namespace App\Rules;

use App\Models\Cashout;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Contracts\Validation\Rule;

class CashoutRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
        $this->message = null;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $playerList = $this->game->getPlayers()->pluck('id');
        $total = 0;
        foreach($value as $playerId => $amount) {
            $player = Player::find($playerId);
            if (!$player || !$playerList->contains($playerId)) {
                $this->message = $player->name . ' is not authorized on this game';
                return false;
            }

            $total += $amount;
        }

        $this->total = $total;

        return (intval($total) === intval($this->game->getTotalDeposits()));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->message !== null) {
            return $this->message;
        } else {
            return "The cashed out amount of {$this->total} does not match {$this->game->getTotalDeposits()}";
        }
    }
}
