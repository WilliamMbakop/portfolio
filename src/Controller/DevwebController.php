<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DevwebController extends AbstractController
{
    #[Route('competences/developpement-web', name: 'app_dev_web')]
    public function index() : response
    {
        $template = 'fragments/body/competences/_dev-web.html.twig';

        return $this->render($template, [
        ]);
    }
}