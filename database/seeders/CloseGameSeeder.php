<?php
 
namespace Database\Seeders;

use App\Models\Cashout;
use App\Models\Deposit;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
 
class CloseGameSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $games = Game::factory()
            ->count(5)
            ->create();

        foreach ($games as $game) {
            $players = Player::factory()
                ->count(8)
                ->create();
            $total = 0;
            foreach ($players as $player) {
                $deposits = Deposit::factory()
                    ->count(2)
                    ->create([
                        'game_id' => $game->id,
                        'player_id' => $player->id,
                    ]);
                $total = $total + $deposits->reduce(function ($carry, $deposit) {
                    return $carry + $deposit->amount;
                });
            }

            $total = $total / 8;

            foreach ($players as $player) {
                Cashout::factory()
                    ->count(1)
                    ->create([
                        'game_id' => $game->id,
                        'player_id' => $player->id,
                        'amount' => $total
                    ]);
            }
        }
    }
}