<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Cashout;
use App\Models\Game;
use App\Models\Player;

class CashoutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cashout::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'game_id' => Game::factory(),
            'player_id' => Player::factory(),
            'amount' => $this->faker->randomFloat(2, 0, 999.99),
        ];
    }
}
