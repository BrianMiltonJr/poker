
    @extends('layouts.app')

    @section('content')
        <x-presenter.game gameId="{{ $game->id }}"/>
        {{ $playersTable->render() }}
    @endsection
