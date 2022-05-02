<section class="container mx-auto bg-white rounded-xl p-4">
    <div class="flex items-center space-x-2 text-base">
        <h4 class="font-semibold text-slate-900">{{ $player->name }}</h4>
        <div class="text-sm font-medium">
            <a 
                class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700" 
                href="{{ route('game.show', $player->getBestGame()) }}"
                >
                Top Game🔥
            </a>  
        </div>
    </div>
    <div class="flex items-center space-x-1 text-base">
        <h5 class="text-slate-700">All Time Net</h5>
        @php($net = $player->getNet())
        <span
        @if ($net < 0)
            class="text-red-400"
        @elseif ($net > 0)
            class="text-green-400"
        @else
            class="text-slate-400"
        @endif
        >
            ${{ $net }}
        </span>
    </div>
</section>