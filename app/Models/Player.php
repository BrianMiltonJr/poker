<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Player extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function cashouts()
    {
        return $this->hasMany(Cashout::class);
    }

    public function getNet()
    {
        return $this->getStats()->reduce(function ($carry, $stat) {
            return $carry + $stat['difference'];
        });
    }

    public function getBestGame()
    {
        return $this->getStats()->sortBy('difference')->last()['game'];
    }

    public function getStats(): Collection
    {
        return $this->getGames()->map(function ($val) {
            return $this->getGameStats($val);
        });
    }

    public function getGameStats(Game $game): Collection
    {
        $deposits = $this->deposits()->where('game_id', $game->id)->get()->reduce(function ($carry, $item) {
            return $carry + $item->amount;
        });
        $cashouts = $this->cashouts()->where('game_id', $game->id)->get()->reduce(function ($carry, $item) {
            return $carry + $item->amount;
        });

        return collect([
            'game' => $game,
            'player' => $this,
            'deposit' => $deposits,
            'cashout' => $cashouts ?? 0,
            'difference' => $cashouts - $deposits,
        ]);
    }

    public function getGames(): Collection
    {
        return Game::whereIn('id', $this->deposits()->distinct()->pluck('game_id'))->get();
    }
}
