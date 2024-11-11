<?php

namespace App\Controller\Public;

use App\Repository\PresentationRepository;
use App\Repository\ParcoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request, PresentationRepository $presentationRepository, ParcoursRepository $parcoursRepository): response
    {

        $section = $request->get('section');

        if (isset($section)) {
            switch ($section) {
                case 'presentation':
                    $template = 'public/fragments/body/_presentation.html.twig';
                    break;
                case 'parcours':
                    $template = 'public/fragments/body/_parcours-pro.html.twig';
                    break;
                case 'competences/sys-res':
                    $template = 'public/fragments/body/competences/_sys-res.html.twig';
                    break;
                case 'competences/dev-web':
                    $template = 'public/fragments/body/competences/_dev-web.html.twig';
                    break;
                case 'competences/collaboration':
                    $template = 'public/fragments/body/competences/_collaboration.html.twig';
                    break;
                case 'competences/certifications':
                    $template = 'public/fragments/body/competences/_certifications.html.twig';
                    break;
                case 'projets-techniques':
                    $template = 'public/fragments/body/_projets-techniques.html.twig';
                    break;
                default:
                    $template = 'public/fragments/body/_veille-technologique.html.twig';
                    break;
            }
        } else {
            $template = 'public/full-page.html.twig';
        }
        return $this->render($template, [
            'presentation' => $presentationRepository->findAll()[0],
            'parcourss' => $parcoursRepository->findAll(),
        ]);
    }
}
