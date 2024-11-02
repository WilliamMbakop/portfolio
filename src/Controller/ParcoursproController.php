<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ParcoursproController extends AbstractController
{
    #[Route('/parcours', name: 'app_parcours')]
    public function index() : response
    {
        $template = 'fragments/body/_parcours-pro.html.twig';

        return $this->render($template, [
        ]);
    }
}