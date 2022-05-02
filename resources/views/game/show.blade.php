
    @extends('layouts.app')

    @section('content')
        <div>
            {{-- @dd($game->start) --}}
            <p>{{ $game->start }}</p>
        </div>
        <div>
            <h5>Players</h5>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Deposits</th>
                        <th>Cashout</th>
                        <th>Difference</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($game->getPlayers() as $player)
                    @php($stats = $player->getGameStats($game))
                    <tr>
                        <td>{{ $player->name }}</td>
                        <td>{{ $stats['deposit'] }}</td>
                        <td>{{ $stats['cashout'] }}</td>
                        @if ($game->end === null)
                            <td>N/A</td>
                        @else
                            <td>{{ $stats['difference'] }}</td>
                        @endif
                        <td>
                            <a href="{{ route('player.show', $player) }}">View Player</a>
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            @if($game->end === null)
                <a href="{{ route('game.deposit.create', $game) }}">Deposit Money</a>
                <a href="{{ route('game.cashout.create', $game) }}">End Game</a>
            @endif
        </div>
    @endsection

