import { Controller } from '@hotwired/stimulus';
import { Modal } from "bootstrap";

export default class extends Controller {
    static targets = ['modal', 'modalBody'];
    static values = { url: String };

      async show(event) {

        const params = new URLSearchParams({
                id: event.params.id,
                title: event.params.title
            });

        this.modalBodyTarget.innerHTML = 'Chargement...';
        this.modal = new Modal(this.modalTarget);
        this.modalBodyTarget.innerHTML = await $.ajax(`${this.urlValue}?${params.toString()}`);
        this.modal.show();
    }
}