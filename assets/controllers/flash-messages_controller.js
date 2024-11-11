import { Controller } from '@hotwired/stimulus';
import Swal from 'sweetalert2';

export default class extends Controller {

    static values = {
        icon: String,
        title: String,
        position: String,
        iconHtml: String,
        text: String,
        width: String,
        background: String,
        color : String,
        iconColor : String,
        timer: Number,
    }

    connect() {
        const Toast = Swal.mixin({
            toast: true,
            position: this.positionValue || "top-end",
            text: this.textValue || null,
            width: this.widthValue || null, 
            color: this.colorValue || '#fff',  
            background: this.backgroundValue || null,
            showConfirmButton: false,
            //popup: 'swal2-show',
            //backdrop: 'swal2-backdrop-show',
            // icon: 'swal2-icon-show'|| null,
            timer: this.timerValue || 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            }
          });
          Toast.fire({
            icon: this.iconValue || 'success',
            title: this.titleValue || 'Génial',
            iconColor: this.iconColorValue || '#fff',  
          });
    }
}