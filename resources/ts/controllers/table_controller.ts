import { ApplicationController } from "./ApplicationController";

export default class extends ApplicationController {

    static values = {
    };

    static targets = [
        "table", "searchParams", "searchButton"
    ];

    declare readonly tableTarget: HTMLTableElement;
    declare readonly searchParamsTarget: HTMLInputElement;
    declare readonly searchButtonTarget: HTMLButtonElement;

    connect() {
        console.log(this.tableTarget);
        console.log(this.searchParamsTarget);
        this.bindEventListeners();
    }

    bindEventListeners() {
        this.searchButtonTarget.addEventListener('click', this.search.bind(this));
    }

    search(event: Event) {
        let parameter = this.searchParamsTarget.value;

        window.location.href = window.location.href + `?search=${parameter}`;
    }
}