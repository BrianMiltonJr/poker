import { Controller } from 'stimulus';

interface AnswerObject {
    [k: string]: string
}

export interface InsertEvent {
    title: string,
    body: HTMLElement,
    submission?: (data: AnswerObject) => void,
    lastAnswer?: AnswerObject
}

enum Selectors {
    SCRAPE = 'modal-scrape',
}

export default class extends Controller {

    static values = {
    }

    static get targets() {
        return [ "title", "body", "submit", "crossClose", "buttonClose" ];
    }

    declare readonly titleTarget: HTMLHeadingElement;
    declare readonly bodyTarget: HTMLDivElement;
    declare readonly submitTarget: HTMLButtonElement;
    declare readonly crossCloseTarget: HTMLButtonElement;
    declare readonly buttonCloseTarget: HTMLButtonElement;
    declare submissionFunction: (data: AnswerObject) => void | undefined;
    declare lastAnswer: AnswerObject | undefined;

    connect() {
        console.log('Setting up Modal Theatre');
        this.bindEventListners();
        //@ts-ignore
        this.modal = new Modal(this.element);
    }

    handleSubmission(event: Event) {
        if (this.submissionFunction !== undefined) {
            this.submissionFunction(this.scrapeAnswers());
        }
    }

    handleInsertThenOpen(event: CustomEvent) {
        this.handleInsertModalData(event);
        this.show();
    }

    handleInsertModalData(event: CustomEvent) {
        let data: InsertEvent = event.detail;
        this.setModalStructure(data);        
    }

    handleConfirmClose(event?: Event): void {
        if(this.submissionFunction !== undefined && confirm('Are you sure you want to close this modal?')) {
            this.hide();
        } else {
            this.hide();
        }
    }

    private scrapeAnswers(): AnswerObject {
        let object = {};

        this.element.querySelectorAll(`[${Selectors.SCRAPE}]`).forEach(element => {
            let key = element.getAttribute(Selectors.SCRAPE);
            //@ts-ignore
            let value = element.value;

            if (key !== null && value !== null) {
                try {
                    object[key] = JSON.parse(value);
                } catch (e) {
                    object[key] = value;
                }
            }
        });

        if (this.lastAnswer !== undefined) {
            return Object.assign(object, this.lastAnswer);
        } else {
            return object;
        }
    }

    private show(event?: Event) {
        //@ts-ignore
        this.modal.show();
    }
    
    private close(event?: Event) { this.hide(event); }
    private hide(event?: Event) {
        //@ts-ignore
        this.modal.hide();
    }

    private bindEventListners() {
        //@ts-ignore
        this.element.addEventListener('insert', this.handleInsertModalData.bind(this));
        //@ts-ignore
        this.element.addEventListener('insertThenOpen', this.handleInsertThenOpen.bind(this));
        this.element.addEventListener('show', this.show.bind(this));
        this.element.addEventListener('hide', this.hide.bind(this));
        this.submitTarget.addEventListener('click', this.handleSubmission.bind(this));
        this.crossCloseTarget.addEventListener('click', this.handleConfirmClose.bind(this));
        this.buttonCloseTarget.addEventListener('click', this.handleConfirmClose.bind(this));
        console.log('Finished Binding Events');
    }

    private setModalStructure(data: InsertEvent): void {
        this.titleTarget.innerText = data.title;
        this.bodyTarget.innerHTML = '';
        this.bodyTarget.append(data.body);
        if (data.submission !== undefined) {
            this.submissionFunction = data.submission?.bind(this);
            //@ts-ignore
            this.modal.show();
        } else {
            //@ts-ignore
            this.modal.hide();
        }

        this.lastAnswer = data.lastAnswer;
    }

    private nextScreen(
        title: string,
        body: HTMLElement,
        submission?:  (data: AnswerObject) => void,
        oldData?: AnswerObject
    ) {
        this.element.dispatchEvent(new CustomEvent('insert', {
            detail: {
                title: title,
                body: body,
                submission: submission,
                lastAnswer: oldData,
            }
        }));
    }
}