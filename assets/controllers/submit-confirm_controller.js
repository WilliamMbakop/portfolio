import { Controller } from '@hotwired/stimulus';
import Swal from 'sweetalert2'

export default class extends Controller {

    static values = {
        title: String,
        text: String,
        icon: String,
        cancelButtonText: String,
        confirmButtonText: String,
    }

    onSubmit(event) {        
        event.preventDefault();
        Swal.fire({
            title: this.titleValue || null,
            text: this.textValue || null,
            icon: this.iconValue || null,
            showCancelButton: true,
            // confirmButtonColor: "#3085d6",
            // cancelButtonColor: "#d33",
            cancelButtonText: this.cancelButtonTextValue || 'Annuler',
            confirmButtonText: this.confirmButtonTextValue || 'Supprimer',            
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return this.submitForm();
            }
        })
    }

    submitForm() {
        this.element.submit()
    };
}