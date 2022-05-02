@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('game.cashout.store', $game) }}">
        @csrf
        @foreach ($players as $player)
            @php($name = "amounts[{$player->id}]")
            <label>{{ $player->name }}</label>
            <input value="{{ old($name) }}" name="{{ $name }}" type="number" step=".25" min="0" max="300"/>
            <br>
        @endforeach
        <input type="submit" value="Submit Cashout"/>
    </form>
@endsection