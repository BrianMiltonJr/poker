@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('game.deposit.store', $game) }}">
        @csrf
        <select value="{{ old('player') }}" name="player">
            @foreach ($players as $player)
            <option value="{{ $player->id }}">{{ $player->name }}</option>
            @endforeach
        </select>
        <input value="{{ old('amount') }}" name="amount" type="number" step=".25" min="0" max="300"/>
        <input type="submit" value="Submit Deposit"/>
    </form>
@endsection