import {Controller} from '@hotwired/stimulus';
import $ from 'jquery';
import 'summernote/dist/summernote-bs4';
import 'summernote/dist/lang/summernote-fr-FR.min.js';

export default class extends Controller {

    static values = {
        height: Number,
        focus: Boolean,
        style: Array,
        font: Array,
        fontsize: Array,
        color: Array,
        para: Array,
        insert: Array,
        misc: Array,
        codeviewFilter: Boolean,
        placeholder: String,

    }

    connect() {

        let $summernote = $(this.element).find('.summernote');
        $summernote.summernote({
            lang: 'fr-FR',
            dialogsInBody: true,
            height: this.heightValue || 300,
            focus: this.focusValue || true,
            toolbar: [
                this.styleValue,
                this.fontValue,
                this.fontsizeValue,
                this.colorValue,
               this.paraValue,
                this.insertValue,
                this.miscValue,
            ],
            disableDragAndDrop: true,
            codeviewFilter: this.codeviewFilterValue || true,
            placeholder: this.placeholderValue
        });
    }
}