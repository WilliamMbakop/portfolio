<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SysresController extends AbstractController
{
    #[Route('competences/systemes-reseaux', name: 'app_sys_res')]
    public function index() : response
    {
        $template = 'fragments/body/competences/_sys-res.html.twig';

        return $this->render($template, [
        ]);
    }
}