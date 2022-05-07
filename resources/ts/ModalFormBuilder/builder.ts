interface Props {
    [k: string]: string
};

export class Builder {
    static wrapForEvent(...elements: HTMLElement[]): HTMLDivElement {
        let div = document.createElement('div');
        elements.forEach(element => {
            div.append(element);
        });

        return div;
    }

    static input(key: string, title: string, properties?: Props): HTMLDivElement {
        let label = this.buildLabel(title);
        let input = document.createElement('input');
        input.className = 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500';
        
        if (properties !== undefined) {
            input = this.setProperties(properties, input);
        }

        input = this.setScrape(key, input);

        return this.buildContainer(label, input);
    }

    static select(key: string, title: string, options: {title: string, value?: string}[], properties?: Props): HTMLDivElement {
        let label = this.buildLabel(title);
        let select = document.createElement('select');
        select.className = 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500';
        if (properties !== undefined) {
            select = this.setProperties(properties, select);
        }
        options.forEach(option => {
            let opt = document.createElement('option');
            opt.innerText = option.title;
            opt.value = (option.value !== undefined) ? option.value : option.title;
            select.append(opt);
        });
        select = this.setScrape(key, select);

        return this.buildContainer(label, select);
    }

    static buildLabel(s: string): HTMLLabelElement {
        let label = document.createElement('label');
        label.className = 'block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300';
        label.innerText = s;
        return label;
    }

    static buildContainer(...elements: HTMLElement[]): HTMLDivElement {
        let container = document.createElement('div');
        container.className = 'mb-6';
        elements.forEach(element => {
            container.append(element);
        });
        return container;
    }

    static setScrape<T extends HTMLElement>(key: string, element: T): T {
        element.setAttribute('modal-scrape', key);
        return element;
    }

    static setProperties<T extends HTMLElement>(properties: Props, element: T): T {
        let keys = Object.keys(properties);
        keys.forEach(key => {
            element.setAttribute(key, properties[key]);
        });

        return element;
    }
}