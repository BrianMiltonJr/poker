<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
        'end' => 'datetime',
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

    public function chipTypes()
    {
        return $this->hasMany(Chip::class);
    }

    public function getStats()
    {
        return $this->getPlayers()->map(function ($player) {
            return $player->getGameStats($this);
        });
    }

    public function getTotalDeposits()
    {
        $total = $this->deposits->reduce(function ($carry, $deposit) {
            return $carry + $deposit->amount;
        });

        return $total > 0 ? '$' . $total : 'N/A';
    }

    public function getTotalDepositsByDenomination(): array
    {
        return collect($this->deposits->map(function ($deposit) {
            return json_decode($deposit->schema, true);
        })->reduce(function ($carry, $obj) {
            if ($carry === null) {
                $carry = [];
            }
            foreach ($obj as $denomination => $amount) {
                if (!array_key_exists($denomination, $carry)) {
                    $carry[$denomination] = 0;
                }

                $carry[$denomination] += $amount;
            }

            return $carry;
        }))->sortKeysDesc()->toArray();
    }

    public function getTotalCashouts()
    {
        $total = $this->cashouts->reduce(function ($carry, $cashout) {
            return $carry + $cashout->amount;
        });

        return $total > 0 ? '$' . $total : 'N/A';
    }

    public function getWinners(): Collection
    {
        return $this->getStats()->sortByDesc('difference')->take(3);
    }

    public function getBiggestDepositor(): Player | null
    {
        if ($this->deposits->count() === 0) {
            return null;
        }
        $stats = collect($this->getStats()->reduce(function ($carry, $stat) {
            // dd($stat);
            $playerId = $stat['player']->id;
            if ($carry === null) {
                $carry = [];
            }
            if (! array_key_exists($playerId, $carry) ) {
                $carry[$playerId] = [
                    'deposit' => 0,
                    'player' => $stat['player'],
                ];
            }

            $carry[$playerId]['deposit'] = $carry[$playerId]['deposit'] + $stat['deposit'];
            return $carry;
        }));

        return $stats->sortBy('deposit')->last()['player'];
    }

    public function isSameDay()
    {
        $start = $this->start->format('z');
        $end = $this->end->format('z');

        return $start === $end;
    }

    public function isFinished()
    {
        return $this->end !== null;
    }

    public function getTableView(): string
    {
        return $this->start->format('l, jS F');
    }
}
