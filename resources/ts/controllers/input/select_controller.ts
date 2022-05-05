import { ApplicationController } from "../ApplicationController";

export default class extends ApplicationController {

    static targets = [
        "select"
    ];

    declare readonly selectTarget: HTMLSelectElement;

    connect() {
        $(this.selectTarget).select2({
            theme: 'bootstrap'
        });
    }
}