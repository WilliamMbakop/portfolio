<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjetstechniquesController extends AbstractController
{
    #[Route('/projets-techniques', name: 'app_projets_techniques')]
    public function index() : response
    {
        $template = 'fragments/body/_projets-techniques.html.twig';

        return $this->render($template, [
        ]);
    }
}