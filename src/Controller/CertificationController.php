<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CertificationController extends AbstractController
{
    #[Route('competences/certification', name: 'app_certification')]
    public function index() : response
    {
        $template = 'fragments/body/competences/_certification.html.twig';

        return $this->render($template, [
        ]);
    }
}