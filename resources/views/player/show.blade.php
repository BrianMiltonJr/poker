
    @extends('layouts.app')

    @section('content')
        <div>
            {{ $player->name }}
        </div>
        <div>
            @php($stats = $player->getStats())
            <h5>Games</h5>
            <table>
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>Deposited</th>
                        <th>Cashed Out</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                @foreach ($stats as $stat)
                <tr>
                    <td>{{ $stat['game']->start }} - {{ $stat['game']->end }}</td>
                    <td>{{ $stat['deposit']}}</td>
                    <td>{{ $stat['cashout']}}</td>
                    <td>
                        <a href="{{ route('game.show', $stat['game']) }}">View</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    @endsection

