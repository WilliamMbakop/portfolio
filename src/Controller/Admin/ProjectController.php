<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ProjectController extends AbstractController
{
    #[Route('/admin/projet', name: 'app_admin_project')]
    public function index(Request $request, ProjectRepository $projectRepository): response
    {

        $template = $request->get('ajax') ? 'admin/project/_list.html.twig' : 'admin/project/index.html.twig';

        return $this->render($template, [
            'projects' => $projectRepository->findAll(),
            'title' => 'Admin | Projets'
        ]);
    }

    /**
     * Add a new Project entity.
     *
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the new entity.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */
    #[Route(path: '/admin/projet/ajouter', name: 'app_admin_project_add')]
    public function add(EntityManagerInterface $entityManager, Request $request): Response
    {

        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");
                return new Response(null, 204);
            }
        }

        $template = 'admin/project/_add.html.twig';

        return $this->render(
            $template,
            [
                'form' => $form->createView(),
            ],
            new Response(
                null,
                $form->isSubmitted() ? 422 : 200,
            )
        );
    }




    /**
     * Edit Project entity.
     *
     * @param Project $Project The Project entity to edit.
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the changes.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */

    #[Route(path: '/admin/projet/{id}/modifier', name: 'app_admin_project_edit', requirements: ['id' => '\d+'])]
    public function edit(Project $project, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");

                return new Response(null, 204);
            }

            return $this->redirectToRoute('app_admin_project');
        }

        return $this->render('admin/project/_add.html.twig', [
            'form' => $form,
        ]);
    }



    /**
     * Delete a Project
     *
     * @param Project $Project The Project to be deleted
     * @param EntityManagerInterface $entityManager The entity manager used for database operations
     * @param Request $request The current HTTP request
     *
     * @return Response A response object representing the redirection to the list page after deletion
     *
     * @throws AccessDeniedException If the user does not have the ROLE_ADMIN role
     */

    #[Route(path: '/admin/projet/{id}/supprimer', name: 'app_admin_project_delete', requirements: ['id' => '\d+'])]
    public function delete(Project $Project, EntityManagerInterface $entityManager, Request $request): Response
    {

        if ($this->isCsrfTokenValid('delete' . $Project->getId(), $request->request->get('_token'))) {
            $entityManager->remove($Project);
            $entityManager->flush();
            $this->addFlash('success', "");
        }

        return $this->redirectToRoute('app_admin_project');
    }
}
