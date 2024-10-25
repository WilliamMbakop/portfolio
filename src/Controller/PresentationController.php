<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PresentationController extends AbstractController
{
    #[Route('/', name: 'app_presentation')]
    public function index() : response
    {
        $template = 'fragments/body/_presentation.html.twig';

        return $this->render($template, [
        ]);
    }
}