import { Controller } from '@hotwired/stimulus';
import $ from "jquery"
import "select2"

export default class extends Controller {
  static targets = ['content', 'select']
  static values = {
    url: String,
  }

  connect() {
    // Initialisation de select2
 $(this.selectTarget).select2();

    // Attachement de l'événement "change" avec la liaison explicite du contexte
    $(this.selectTarget).on('change', this.onSelectChange.bind(this))  // Lier "this" au contrôleur
  }


  async onSelectChange(event) {

      const selectedOption = $(event.currentTarget).find('option:selected');
      const selectedId = selectedOption.attr('id');

    // console.log(selectedId)


  // Récupérer la valeur sélectionnée
  const selectedValue = $(event.target).val()

   const params = new URLSearchParams({
            selectedOptionValue: selectedValue,

        });

    this.element.style.opacity = 0.5;
    const response = await fetch(`${this.urlValue}?${params.toString()}`);
    this.contentTarget.innerHTML = await response.text();
    this.element.style.opacity = 1;
}

}
