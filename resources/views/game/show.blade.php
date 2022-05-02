
    @extends('layouts.app')

    @section('content')
        <x-presenter.game gameId="{{ $game->id }}"/>
        <?php
            $playerIds = $game->getPlayers()->pluck('id');

            $table = new App\View\Components\Table(
                ['Name', 'Deposits', 'Cashout', 'Difference'],
                App\Models\Player::whereIn('id', $playerIds),
                function ($player, $index) use($game) {
                    $stats = $player->getGameStats($game);

                    $this->addAction($index, 'View Player', route('player.show', $player));

                    return [
                        $player->name,
                        $stats['deposit'],
                        $stats['cashout'],
                        $game->end !== null ? $stats['difference'] : 'N/A',
                    ];
                }
            )
        ?>
        {{ $table->render() }}
        <div>
            @if($game->end === null)
                <a href="{{ route('game.deposit.create', $game) }}">Deposit Money</a>
                <a href="{{ route('game.cashout.create', $game) }}">End Game</a>
            @endif
        </div>
    @endsection

