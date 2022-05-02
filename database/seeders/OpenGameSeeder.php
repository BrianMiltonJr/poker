<?php
 
namespace Database\Seeders;

use App\Models\Deposit;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
 
class OpenGameSeeder extends Seeder
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
            ->create([
                'end' => null
            ]);

        foreach ($games as $game) {
            $players = Player::factory()
                ->count(8)
                ->create();
            foreach ($players as $player) {
                $deposits = Deposit::factory()
                    ->count(2)
                    ->create([
                        'game_id' => $game->id,
                        'player_id' => $player->id,
                    ]);
            }
        }
    }
}