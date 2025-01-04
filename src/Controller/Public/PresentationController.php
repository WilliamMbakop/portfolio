<?php

namespace App\Controller\Public;

use App\Repository\PresentationRepository;
use App\Repository\SocialNetworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PresentationController extends AbstractController
{

    #[Route('/profil', name: 'app_public_profil_index')]
    public function index(
        Request $request,
        PresentationRepository $presentationRepository,
        SocialNetworkRepository $socialNetworkRepository,
    ): response {

        $template = 'public/fragments/body/presentation/index.html.twig';

        return $this->render($template, [
            'presentation' => $presentationRepository->findAll()[0],
            'socialnetworks' => $socialNetworkRepository->findAll(),
        ]);
    }
}
