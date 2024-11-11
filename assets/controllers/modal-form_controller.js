import {Controller} from '@hotwired/stimulus';
import {Modal} from "bootstrap";
import $ from 'jquery';
import {useDispatch} from 'stimulus-use';

export default class extends Controller {
    static targets = ['modal', 'modalBody'];
    static values = {
        formUrl: String,
    }

    modal = null;

    connect() {
        useDispatch(this, {debug: true});
    }

    async openModal(event) {
        this.modalBodyTarget.innerHTML = 'Chargement...';
        this.modal = new Modal(this.modalTarget);
        this.modal.show();
        this.modalBodyTarget.innerHTML = await $.ajax(this.formUrlValue);
    }

    async sumbitForm(event) {
        event.preventDefault();
        const $form = $(this.modalBodyTarget).find('form');

        let formData = new FormData($form[0]);

        try {
            await $.ajax({
                url: this.formUrlValue,
                method: $form.prop('method'),
                data: formData,
                processData: false,
                contentType: false,
            });
            this.modal.hide();
            this.dispatch('success');

        } catch (e) {
            this.modalBodyTarget.innerHTML = e.responseText;
        }
    }
}