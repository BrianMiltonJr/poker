
    @extends('layouts.app')

    @section('content')
        <x-presenter.player playerId="{{ $player->id }}"/>
        {{ $playerTable->render() }}
    @endsection

