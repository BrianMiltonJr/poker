
    @extends('layouts.app')

    @section('content')
        <x-presenter.game gameId="{{ $game->id }}"/>
        {{ $playersTable->render() }}
        <div>
            @if($game->end === null)
                <a href="{{ route('game.deposit.create', $game) }}">Deposit Money</a>
                <a href="{{ route('game.cashout.create', $game) }}">End Game</a>
            @endif
        </div>
    @endsection

