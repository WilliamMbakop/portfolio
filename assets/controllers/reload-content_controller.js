import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static targets = ['content','presentation', 'parcourspro'];

    static values = {
        url: String
    }

   async refreshContent(event) {
  
        const button = event.currentTarget;
        const section = button.dataset.reloadContentSectionParam;
        //console.log(section);

        const params = new URLSearchParams({
            section: section
        });

        const response = await fetch(`${this.urlValue}?${params.toString()}`);
        this.contentTarget.innerHTML = await response.text();
        //console.log(response)
    }
}
