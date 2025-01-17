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


    #[Route('/projet', name: 'app_public_projet_index')]
    public function index(
        Request $request,
        SocialNetworkRepository $socialNetworkRepository,
        ProjectRepository $projectRepository,
    ): response {

        $template = 'public/fragments/body/projet/_index.html.twig';

        return $this->render($template, [
            'socialnetworks' => $socialNetworkRepository->findAll(),
            'projects' => $projectRepository->findAll(),
        ]);
    }

    #[Route('/projet/modal', name: 'app_public_projet_modal')]
    public function modal(
        Request $request,
        SocialNetworkRepository $socialNetworkRepository,
        ProjectRepository $projectRepository,
    ): response {

        $id = $request->query->get('id');

        $template = 'public/fragments/body/projet/_showModal.html.twig';

        return $this->render($template, [
            'project' => $projectRepository->findOneById($id),
        ]);
    }
}
