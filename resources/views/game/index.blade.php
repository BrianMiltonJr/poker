
    @extends('layouts.app')

    @section('content')
        <table>
            <thead>
                <tr>
                    <th>Game Date</th>
                    <th>Total Deposits</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $game)
                    <tr>
                        <td>{{ $game->start }} - {{ $game->end }}</td>
                        <td>{{ $game->getTotalDeposits() }}</td>
                        <td>
                            <a href="{{ route('game.show', $game) }}">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection

