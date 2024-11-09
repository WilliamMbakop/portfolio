<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request) : response
    {
      $section = $request->get('section');

if (isset($section)) {
    switch ($section) {
        case 'presentation':
            $template = 'fragments/body/_presentation.html.twig';
            break;
        case 'parcours':
            $template = 'fragments/body/_parcours-pro.html.twig';
            break;
        case 'competences/sys-res':
            $template = 'fragments/body/competences/_sys-res.html.twig';
            break;
        case 'competences/dev-web':
            $template = 'fragments/body/competences/_dev-web.html.twig';
            break;
        case 'competences/collaboration':
            $template = 'fragments/body/competences/_collaboration.html.twig';
            break;
        case 'competences/certifications':
            $template = 'fragments/body/competences/_certifications.html.twig';
            break;
        case 'projets-techniques':
            $template = 'fragments/body/_projets-techniques.html.twig';
            break;
        default:
            $template = 'fragments/body/_veille-technologique.html.twig';
            break;
    }
} else {
    $template = 'full-page.html.twig';
}
        return $this->render($template, [
        ]);
    }
}