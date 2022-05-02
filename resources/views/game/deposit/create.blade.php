@extends('layouts.app')

@section('content')
<div class="w-full max-w-xs">
    <form method="POST" action="{{ route('game.deposit.store', $game) }}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
    <div class="mb-4">
        {{ $playerSelect->render() }}
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                Amount
            </label>
            <input name="amount" type="number" min="10" step="0.25" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        </div>

        <div class="flex items-center">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Submit Deposit
        </button>
        </div>
    </form>
</div>
@endsection