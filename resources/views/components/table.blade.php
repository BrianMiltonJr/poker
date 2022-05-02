<section class="container mx-auto bg-white rounded-xl mt-4">
    <div class="flex items-center">
        <table class="table-auto">
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
    </div>
</section>