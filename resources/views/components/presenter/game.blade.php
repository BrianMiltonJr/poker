<section class="container mx-auto bg-white rounded-xl">
    <div class="flex items-center space-x-2 text-base">
        <h4 class="font-semibold text-slate-900">
            {{ $game->start->format('l M jS Y') }}
        </h4>
        @if ($game->isFinished() && ! $game->isSameDay())
        <span class="text-slate-700"> to </span>
        <h4 class="font-semibold text-slate-900">
            {{ $game->start->format('l M jS Y') }}
        </h4>
        @endif
    </div>
    <div class="flex items-center space-x-2 text-base">
        <p>Start: {{ $game->start->format('h:i a') }}</p>
        <p>End: {{ $game->isFinished() ? $game->end->format('h:i a') : 'N/A'}}</p>
    </div>
    <div>
        Total Deposits: {{ $game->getTotalDeposits() }}
    </div>
    <div>
        @php($bigBoy = $game->getBiggestDepositor())
        Biggest Depositor: {{ $bigBoy->name ?? 'N/A' }}
    </div>
    @php($winners = $game->getWinners())
    <div class="flex">
        <div>
            <h4 class="font-semibold text-slate-900">Winners</h4>
            <div class="mt-3 flex space-x-2">
                @foreach($winners as $winner)
                <p>{{ $winner['player']->name }}</p>
                @endforeach
            </div>
        </div>
    </div>
</section>