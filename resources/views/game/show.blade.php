
    @extends('layouts.app')

    @section('content')
        <x-presenter.game gameId="{{ $game->id }}"/>
        <br>
        <?php
            $table = new App\View\Components\Table(
                ['Name', 'Deposits', 'Cashout', 'Difference'],
                App\Models\Player::where('id', '>', 0),
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

