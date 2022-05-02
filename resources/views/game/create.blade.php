@extends('layouts.app')

@section('content')
    <form action="{{ route('game.store') }}" method="POST">
        @csrf
        <input type="datetime-local" name="start"/>
        <input type="submit" value="Create Game"/>
    </form>
@endsection