<?php

namespace App\Controller\Public;

use App\Repository\CategoryRepository;
use App\Repository\SocialNetworkRepository;
use App\Repository\TechnoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CompetenceController extends AbstractController
{

    #[Route('/competences', name: 'app_public_competence_index')]
    public function index(
        Request $request,
        SocialNetworkRepository $socialNetworkRepository,
        TechnoRepository $technoRepository,
        CategoryRepository $categoryRepository,
    ): response {

        $template = 'public/fragments/body/competence/index.html.twig';

        return $this->render($template, [
            'socialnetworks' => $socialNetworkRepository->findAll(),
            'competences' => $technoRepository->findAll(),
            'categories' => $categoryRepository->findBy([], ['id' => 'ASC']),
        ]);
    }
}
