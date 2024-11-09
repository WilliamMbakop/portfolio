import { Controller } from '@hotwired/stimulus';
import $ from "jquery";

export default class extends Controller {

   static targets = ['competences', 'navtreeview'];

    colorize(event) {
        // Trouver tous les éléments 'li' dans cet élément
        const menuLinks = $(this.element).find('li');

        // Récupérer l'index du lien cliqué à partir de data-attribute
        const index = event.currentTarget.dataset.menuLinkIndexParam;

        const sousMenuLinks = $(this.navtreeviewTarget).find('li');

        if (!$(this.competencesTarget).hasClass('menu-open')) {
            // Ajouter la classe 'active' au lien sélectionné
            $(event.currentTarget).find('a').addClass('active');

            // Retirer la classe 'active' de tous les autres éléments sauf celui sélectionné
            menuLinks.not(menuLinks[index]).find('a').removeClass('active');
        } else {
            // Si l'élément a la classe 'menu-open'
            // On peut retirer la classe 'active' de tous les éléments
            menuLinks.find('a').removeClass('active');

            // Et ajouter la classe 'active' uniquement au lien sélectionné
            $(event.currentTarget).find('a').addClass('active');
            $(event.currentTarget).find('.nav-treeview').slideDown(); // Ouvrir le sous-menu si nécessaire

            // si on clique sur un lien qui n'est pas dans le sous-menu, le sous-menu se ferme
            if (!$.contains(this.navtreeviewTarget, event.currentTarget)) {
                $('.nav.nav-treeview').slideUp();
                $(this.competencesTarget).removeClass('menu-is-opening menu-open ');
                }
        }
    }
}
