<section class="container mx-auto bg-white rounded-xl p-4">
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
        <h5 class="mt-4">Money by Denominations</h5>
        @foreach ($game->getTotalDepositsByDenomination() as $denomination => $amount)
            <p>${{ $denomination }}: {{ $amount }} (${{$amount * floatval($denomination)}})</p>
        @endforeach
    </div>

    <div>
        Total Deposits: {{ $game->getTotalDeposits() }}
    </div>

    <div class="mt-4">
        @php($bigBoy = $game->getBiggestDepositor())
        Biggest Depositor: {{ $bigBoy->name ?? 'N/A' }}
    </div>
    @if ($game->isFinished())
        @php($winners = $game->getWinners())
        <div class="mt-3 flex">
            <div>
                <h4 class="font-semibold text-slate-900">Winners</h4>
                <div class="flex mt-1">
                    @php($i = 1)
                    @foreach($winners as $winner)
                        <?php
                            if ($i === 1) {
                                $icon = "fas fa-1";
                                $color = "text-yellow-400";
                            } else if ($i === 2) {
                                $icon = "fas fa-2";
                                $color = 'text-gray-500';
                            } else {
                                $icon = "fas fa-3";
                                $color = 'text-yellow-800';
                            }
                            $i++;
                        ?>
                    <div class="flex items-center space-x-1 {{ $color }}">
                        <i class="{{ $icon }}"></i>
                        <p>{{ $winner['player']->name }}</p>
                    <div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</section>