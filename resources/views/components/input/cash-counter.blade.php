<div
    data-controller="input--cash-counter"
    data-input--cash-counter-chip-amounts-value="{{ $chipAmounts }}"
    >
    <div class="mb-4">
        <input type="hidden" data-input--cash-counter-target="output" name="depositSchema"/>
        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
            Amount <span data-input--cash-counter-target="total"></span>
        </label>
        <input data-input--cash-counter-target="userInput" type="number" min="10" step="0.25" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" data-dashlane-rid="9593ee83a977a19f" data-form-type="other">
    </div>
</div>