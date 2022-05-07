import { param } from "jquery";
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
        let newParameters: string = "?";
        if (location.search === '') {
            newParameters += `search=${parameter}`;
        } else {
            let oldParameterRaw = location.search.replace("?", "").split("&");
            for (let i = 0; i < oldParameterRaw.length; i++) {
                let slice = oldParameterRaw[i].split("=");
                if (i > 0) {
                    newParameters += "&";
                }
    
                if (slice[0] !== 'search') {
                    newParameters += `${slice[0]}=${slice[1]}`;
                } else {
                    newParameters += `search=${parameter}`;
                }
            }
        }

        location.href = location.origin + location.pathname + newParameters;
    }
}