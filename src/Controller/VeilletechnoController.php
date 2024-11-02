<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VeilletechnoController extends AbstractController
{
    #[Route('/veille-technologique', name: 'app_veille_technologique')]
    public function index() : response
    {
        $template = 'fragments/body/_veille-technologique.html.twig';

        return $this->render($template, [
        ]);
    }
}