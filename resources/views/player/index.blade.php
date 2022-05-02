
    @extends('layouts.app')

    @section('content')
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($players as $player)
                <tr>
                    <td>{{ $player->name }}</td>
                    <td>
                        <a href="{{ route('player.show', $player) }}">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endsection

