import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';
/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    static targets = ['icon', 'jobcompany'];

   colorize(event) {
    const index = event.target.dataset.indexParam;
    if (event.type === "mouseenter") {
      $(this.iconTargets[index]).addClass('text-yellow'); 
      $(this.jobcompanyTargets[index]).removeClass('text-white').addClass('text-yellow');
    } else if (event.type === "mouseleave") {
        $(this.iconTargets[index]).removeClass('text-yellow'); 
        $(this.jobcompanyTargets[index]).removeClass('text-yellow').addClass('text-white');
    }
}

}
