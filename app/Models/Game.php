<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start',
        'end',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'start' => 'datetime',
        'end' => 'timestamp',
    ];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function cashouts()
    {
        return $this->hasMany(Cashout::class);
    }
    
    public function getPlayers()
    {
        return Player::whereIn('id', $this->deposits()->distinct()->pluck('player_id'))->get();
    }

    public function getStats()
    {
        return $this->getPlayers()->map(function ($player) {
            return $player->getGameStats($this);
        });
    }

    public function getTotalDeposits()
    {
        return $this->deposits->reduce(function ($carry, $deposit) {
            return $carry + $deposit->amount;
        });
    }

    public function getTotalCashouts()
    {
        return $this->cashouts->reduce(function ($carry, $cashout) {
            return $carry + $cashout->amount;
        });
    }
}
