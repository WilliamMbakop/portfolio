<?php

namespace App\Controller\Public;

use App\Repository\CompetenceRepository;
use App\Repository\SocialNetworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CompetenceController extends AbstractController
{

    #[Route('/commpetence', name: 'app_public_competence_index')]
    public function index(
        Request $request,
        SocialNetworkRepository $socialNetworkRepository,
    ): response {

        $template = 'public/fragments/body/competence/index.html.twig';

        return $this->render($template, [
            'socialnetworks' => $socialNetworkRepository->findAll(),
        ]);
    }
}
