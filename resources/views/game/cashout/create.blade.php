@extends('layouts.app')

@section('content')
<div class="w-full max-w-xs">
    <form method="POST" action="{{ route('game.cashout.store', $game) }}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @foreach ($players as $player)
            @php($name = "amounts[{$player->id}]")
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                    {{ $player->name }}
                </label>
            </div>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old($name) }}" name="{{ $name }}" type="number" step=".25" min="0" max="300"/>
            <br>
        @endforeach

        <div class="flex items-center">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Submit Cashout
        </button>
        </div>
    </form>
</div>
@endsection