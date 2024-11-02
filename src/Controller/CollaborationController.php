<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CollaborationController extends AbstractController
{
    #[Route('competences/collaboration', name: 'app_collaboration')]
    public function index() : response
    {
        $template = 'fragments/body/competences/_collaboration.html.twig';

        return $this->render($template, [
        ]);
    }
}