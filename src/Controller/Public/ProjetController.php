<?php

namespace App\Controller\Public;

use App\Repository\ProjectRepository;
use App\Repository\SocialNetworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class ProjetController extends AbstractController
{

    #[Route('/projets', name: 'app_public_projet_index')]
    public function index(
        Request $request,
        SocialNetworkRepository $socialNetworkRepository,
        ProjectRepository $projectRepository,
        SessionInterface $session,
    ): response {

        // Récupération des catégories de projets sélectionnés pour les afficher dans le filtre

        $categories = [];

        $projects = $projectRepository->findBy([], ['id' => 'DESC']);
        foreach ($projects as $project) {
            foreach ($project->getCategories() as $category) {
                $categoryName = $category->getName();
                $categoryId = $category->getId();
                if (!in_array($categoryName, $categories)) {
                    $categories[$categoryId] = $categoryName;
                }
            }
        }

        asort($categories);

        // Récupération des projets

        $categoryIdInSession = $session->get('categoryID');

        if ($categoryIdInSession && is_numeric($categoryIdInSession)) {
            $projects = $projectRepository->findByCategoryId($categoryIdInSession);
        } else {
            $projects = $projectRepository->findBy([], ['id' => 'DESC']);
        }

        $session->set('categoryID', $categoryIdInSession);




        $template = 'public/fragments/body/projet/_index.html.twig';


        return $this->render($template, [
            'socialnetworks' => $socialNetworkRepository->findAll(),
            'projects' => $projects,
            'categories' => $categories,
            'categoryID' => $categoryIdInSession,

        ]);
    }


    #[Route('/projets/show', name: 'app_public_project_show')]
    public function _show(
        Request $request,
        ProjectRepository $projectRepository,
        SessionInterface $session,
    ): response {

        $categoryID = $request->query->get('selectedOptionValue');
        $session->set('categoryID', $categoryID);

        if (!is_numeric($categoryID)) {
            $projects = $projectRepository->findBy([], ['id' => 'DESC']);
        } else {
            $projects = $projectRepository->findByCategoryId($categoryID);
        }


        $template = 'public/fragments/body/projet/_content.html.twig';

        return $this->render($template, [
            'projects' => $projects,
            'categoryID' => $categoryID,
        ]);
    }

    #[Route('/projets/modal', name: 'app_public_projet_modal')]
    public function modal(
        Request $request,
        ProjectRepository $projectRepository,
    ): response {

        $id = $request->query->get('id');
        $title = $request->query->get('title');


        $template = 'public/fragments/body/projet/_showModal.html.twig';

        return $this->render($template, [
            'project' => $projectRepository->findOneById($id),
            'modalTitle' => $title,
        ]);
    }
}
