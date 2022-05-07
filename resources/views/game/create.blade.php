@extends('layouts.app')

@section('content')
<div class="w-full max-w-xs">
    <form method="POST" action="{{ route('game.store') }}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      @csrf
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="start">
          Start Time
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="start" name="start" type="datetime-local">
      </div>

      <x-input.chip-counter/>
     
      <div class="flex items-center">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
          Create Game
        </button>
      </div>
    </form>
  </div>
@endsection