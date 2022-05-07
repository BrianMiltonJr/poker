<section class="container mx-auto bg-white rounded-xl mt-4 p-4">
    <div 
        data-controller="table"
        class="flex flex-col"
    >
        <div class="mb-4">
            @foreach ($headerActions as $button)
            <x-input.button title="{{ $button['title']}}" route="{{ $button['route'] }}" color="{{ $button['color'] }}"/>
            @endforeach
        </div>

        <div 
            @if(count($searchableColumns) === 0)
            hidden
            @endif
            class="mb-4"
        >
            <label class="block text-gray-700 text-sm font-bold mb-2">Search</label>
            <input class="shadow appearance-none border rounded w-half py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" data-table-target="searchParams"/>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" data-table-target="searchButton">Search for Results</button>
        </div>

        <table data-table-target="table" class="table-auto">
            <thead>
                <tr>
                    @foreach ($columns as $column)
                    <th class="px-4 py-2">{{ ucFirst($column) }}</th>
                    @endforeach
                    @if ($hasActions)
                    <th class="px-4 py-2">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $obj)
                    @if($index % 2 === 1)
                        <tr class="bg-gray-100">
                    @else
                        <tr>
                    @endif
                    @foreach($obj as $td)
                        <td class="border px-4 py-2">{{ $td }}</td>
                    @endforeach
                    @if ($hasActions)
                        <td class="border px-4 py-2">
                            @foreach ($actions[$index] as $button)
                            {{-- @dd([$actions, $buttons, $button]) --}}
                            <x-input.button title="{{ $button['title']}}" route="{{ $button['route'] }}" color="{{ $button['color'] }}"/>
                            @endforeach
                        </td>
                    @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $paginator->links() }}
        <?php
            $pageNumber = $paginator->currentPage();
            $count = $paginator->count();
            $perPage = $paginator->perPage();
            
            $start = (($pageNumber * $perPage) - $perPage) + 1;
            $end = (($pageNumber - 1) * ($perPage)) + $count;
        ?>
        {{ $start }} to {{ $end }} of {{ $paginator->total() }}
    </div>
</section>