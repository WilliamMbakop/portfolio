<?php

namespace App\Controller\Public;

use App\Repository\ParcoursRepository;
use App\Repository\SocialNetworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ParcoursController extends AbstractController
{

    #[Route('/parcours', name: 'app_public_parcours_index')]
    public function index(
        Request $request,
        ParcoursRepository $parcoursRepository,
        SocialNetworkRepository $socialNetworkRepository,
    ): response {

        $template = 'public/fragments/body/parcours/index.html.twig';

        return $this->render($template, [
            'parcourss' => $parcoursRepository->findBy([], ['datedeb' => 'DESC']),
            'socialnetworks' => $socialNetworkRepository->findAll(),
        ]);
    }
}
