<div data-controller="input--select">
    <label class="block text-gray-700 text-sm font-bold mb-2">
        {{ $label }}
    </label>
    <select
        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
        data-input--select-target="select"
        name="{{ $name }}"
    >
        @foreach ($options as $option)
            <option value="{{ $option['value'] }}">{{ $option['title'] }}</option>
        @endforeach
    </select>
</div