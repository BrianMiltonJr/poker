import { type } from 'jquery';
import { Builder } from '../../ModalFormBuilder/builder';
import { ApplicationController } from '../ApplicationController';
import { InsertEvent } from '../modal_theatre_controller';

interface ChipType {
    id: number,
    color: string,
    denomination: number,
    amount: number,
}

export default class extends ApplicationController {

    static values = {
        chipAmounts: String
    };

    static targets = [
        'userInput', 'total', 'output'
    ];


    declare modalTheatre: HTMLDivElement;
    declare chipTypes: ChipType[];
    declare readonly userInputTarget: HTMLInputElement;
    declare readonly totalTarget: HTMLSpanElement;
    declare readonly outputTarget: HTMLInputElement;
    declare readonly chipAmountsValue: string;

    connect() {
        //@ts-ignore
        this.modalTheatre = document.getElementById('modal-theatre');
        this.chipTypes = [];
        let obj = JSON.parse(this.chipAmountsValue);
        let keys = Object.keys(obj);

        for(let i = 0; i < keys.length; i++) {
            let key = keys[i];
            this.chipTypes.push({
                id: parseInt(key),
                color: obj[key].color,
                denomination: parseFloat(obj[key].denomination),
                amount: parseInt(obj[key].amount),
            });
        }

        let total = 0;

        this.chipTypes.forEach(type => {
            total += type.denomination * type.amount;
        });

        this.totalTarget.innerText = `(${total})`;

        this.bindEventListeners();
    }

    calculateChipCut(event: Event) {
        let value = parseInt(this.userInputTarget.value);
        let cutter = {};

        this.chipTypes.forEach(type => {
            cutter[type.denomination] = { 
                amount: type.amount,
                color: type.color 
            };
        });

        let chipsToHandout = {};

        let keys = Object.keys(cutter);
        keys.sort((a, b) => {
            //@ts-ignore
            return b - a;
        })

        for (let i = 0; i < keys.length; i++) {
            let key = keys[i];
            let denomination = parseFloat(key);
            let chipAmount = 0;
            if (i === keys.length - 1) {
                chipAmount = Math.floor((value / denomination));
            } else if (i === 0) {
                chipAmount = Math.floor((value / denomination) / 4);
            } else {
                chipAmount = Math.floor((value / denomination) / 2);
            }

            if (chipAmount > cutter[key].amount) {
                chipAmount = cutter[key].amount;
            }
            value -= chipAmount * denomination;
            chipsToHandout[cutter[key]['color']] = chipAmount;
        }

        this.createModal(chipsToHandout);
    }

    private createModal(chipsToHandout) {
        let table = this.createChipTableView(chipsToHandout);

        let body = Builder.wrapForEvent(
            table,
            Builder.input('.25', 'How many Quarters', {
                type: "number",
                min: '0',
                max: '2000',
                step: "1",
                value: "0",
            }),
            Builder.input('1', 'How many 1 Dollar Bills', {
                type: "number",
                min: '0',
                max: '2000',    
                value: "0",
            }),
            Builder.input('5', 'How many 5 Dollar Bills', {
                type: "number",
                min: '0',
                max: '2000',    
                value: "0",
            }),
            Builder.input('10', 'How many 10 Dollar Bills', {
                type: "number",
                min: '0',
                max: '2000',    
                value: "0",
            }),
            Builder.input('20', 'How many 20 Dollar Bills', {
                type: "number",
                min: '0',
                max: '2000',    
                value: "0",
            }),
            Builder.input('50', 'How many 50 Dollar Bills', {
                type: "number",
                min: '0',
                max: '2000',    
                value: "0",
            }),
            Builder.input('100', 'How many 100 Dollar Bills', {
                type: "number",
                min: '0',
                max: '2000',    
                value: "0",
            }),
            Builder.input('chips-to-handout', "", {
                type: 'hidden',
                value: JSON.stringify(chipsToHandout)
            }),
        );

        let cashInstance = this;

        let insertEvent: InsertEvent = {
            title: 'We are almost done',
            body: body,
            submission: function (data) {
                console.log(data);
                cashInstance.outputTarget.value = JSON.stringify(data);
                //@ts-ignore
                this.close();                
            }
        }

        this.modalTheatre.dispatchEvent(new CustomEvent('insertThenOpen', {
            detail: insertEvent
        }));
    }

    private createChipTableView(chipsToHandout): HTMLTableElement {
        let table = document.createElement('table');
        let thead = document.createElement('thead');
        let th = [
            document.createElement('th'),
            document.createElement('th'),
        ];
        th[0].innerText = 'Chip Color';
        th[1].innerText = 'Chip Amount';
        
        thead.append(th[0], th[1]);

        let tbody = document.createElement('tbody');
        let chipKeys = Object.keys(chipsToHandout);
        chipKeys.forEach(key => {
            let tr = document.createElement('tr');
            let color = document.createElement('td');
            let amount = document.createElement('td');

            color.innerText = key;
            amount.innerText = chipsToHandout[key];

            tr.append(color, amount);
            tbody.append(tr);
        });

        table.append(thead, tbody);

        return table;
    }

    private bindEventListeners() {
        this.userInputTarget.addEventListener('change', this.calculateChipCut.bind(this));
    }
}