
    @extends('layouts.app')

    @section('content')
      <div class="bg-white mb-10">
         <h3 class="text-gray">All Games</h3>
      </div>
       {{ $gamesTable->render() }}
    @endsection

