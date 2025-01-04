<?php

namespace App\Controller\Public;

use App\Repository\ProjectRepository;
use App\Repository\SocialNetworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjetController extends AbstractController
{

    private $rssFeedService;

    #[Route('/projet', name: 'app_public_projet_index')]
    public function index(
        Request $request,
        SocialNetworkRepository $socialNetworkRepository,
        ProjectRepository $projectRepository,
    ): response {

        $template = 'public/fragments/body/projet/_index.html.twig';

        return $this->render($template, [
            'socialnetworks' => $socialNetworkRepository->findAll(),
        ]);
    }
}
