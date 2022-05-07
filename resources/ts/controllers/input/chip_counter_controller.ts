import { Builder } from '../../ModalFormBuilder/builder';
import { ApplicationController } from '../ApplicationController';
import { InsertEvent } from '../modal_theatre_controller';

interface ChipInput {
    color: string,
    denomination: string,
    amount: string,
};

export default class extends ApplicationController {

    static values = {};

    static targets = [
        'counterContainer', 'addChipType', 'chipSchema'
    ];

    declare readonly counterContainerTarget: HTMLDivElement;
    declare readonly addChipTypeTarget: HTMLButtonElement;
    declare readonly chipSchemaTarget: HTMLInputElement;

    declare modalTheatre: HTMLDivElement;

    connect() {
        this.modalTheatre = document.getElementById('modal-theatre') as HTMLDivElement;
        this.bindEventListeners();
    }

    bindEventListeners(): void {
        this.addChipTypeTarget.addEventListener('click', this.addChipType.bind(this));
    }

    insertChipContainer(data: ChipInput): void {
        let wrapper = document.createElement('div');
        let removeButton = document.createElement('button');
        removeButton.innerHTML = '&times;';
        removeButton.addEventListener('click', (event: Event) => {
            //@ts-ignore
            event.srcElement.parentElement.remove();
            this.rewriteCurrentChips();
        });

        let color = document.createElement('h6');
        let denomination = document.createElement('p');
        let amount = document.createElement('p');

        wrapper.setAttribute('chipType', JSON.stringify(data));

        color.innerText = `Color: ${data.color}`;
        denomination.innerText = `Denomination: $${data.denomination}`;
        amount.innerText = `Amount: ${data.amount}`;

        wrapper.append(removeButton, color, denomination, amount);

        this.counterContainerTarget.append(wrapper);
        this.rewriteCurrentChips();
    }

    rewriteCurrentChips() {
        let objs = [];
        let chipTypes = document.querySelectorAll('div[chipType]');

        chipTypes.forEach(type => {
            let json = type.getAttribute('chipType');
            if (json !== null) {
                //@ts-ignore
                objs.push(JSON.parse(json));
            }
        });

        this.chipSchemaTarget.value = JSON.stringify(objs);
    }

    addChipType(event: Event) {
        let counterInstance = this;

        let body = Builder.wrapForEvent(
            Builder.select('color', 'What color is this chip type?', [
                { title: 'Black' },
                { title: 'Green' },
                { title: 'White'},
                { title: 'Red' },
            ]),
            Builder.input('denomination', 'What is the denomination?', {
                type: 'number',
                min: "0.25",
                max: "500",
                step: "0.25",                
            }),
            Builder.input('amount', 'What is the total count of these chips?', {
                type: 'number',
                min: "1",
                max: "2000",
                step: "1",
            }),
        );

        let modalInsert: InsertEvent = {
            title: 'Add a Chip Type',
            body: body,
            submission: function (data) {
                counterInstance.insertChipContainer({
                    color: data.color,
                    denomination: data.denomination,
                    amount: data.amount
                });
                //@ts-ignore
                this.close();
            }
        };


        this.modalTheatre.dispatchEvent(new CustomEvent('insertThenOpen', {
            detail: modalInsert
        }));
    }
}