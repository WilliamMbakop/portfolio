<?php

namespace App\Controller\Admin;

use App\Entity\Parcours;
use App\Form\ParcoursType;
use App\Repository\ParcoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ParcoursController extends AbstractController
{
    #[Route('/admin/parcours', name: 'app_admin_parcours')]
    public function index(Request $request, ParcoursRepository $parcoursRepository): response
    {

        $template = $request->get('ajax') ? 'admin/parcours/_list.html.twig' : 'admin/parcours/index.html.twig';

        return $this->render($template, [
            'parcourss' => $parcoursRepository->findAll(),
        ]);
    }

    /**
     * Add a new Parcours entity.
     *
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the new entity.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */
    #[Route(path: '/admin/parcours/ajouter', name: 'app_admin_parcours_add')]
    public function add(EntityManagerInterface $entityManager, Request $request): Response
    {

        $parcours = new Parcours();
        $form = $this->createForm(ParcoursType::class, $parcours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($parcours);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");
                return new Response(null, 204);
            }
        }

        $template = 'admin/parcours/add.html.twig';

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
     * Edit Parcours entity.
     *
     * @param Parcours $Parcours The Parcours entity to edit.
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the changes.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */

    #[Route(path: '/admin/parcours/{id}/modifier', name: 'app_admin_parcours_edit', requirements: ['id' => '\d+'])]
    public function edit(Parcours $parcours, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(ParcoursType::class, $parcours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");

                return new Response(null, 204);
            }

            return $this->redirectToRoute('app_admin_parcours');
        }

        return $this->render('admin/parcours/add.html.twig', [
            'form' => $form,
        ]);
    }



    /**
     * Delete a Parcours
     *
     * @param Parcours $Parcours The Parcours to be deleted
     * @param EntityManagerInterface $entityManager The entity manager used for database operations
     * @param Request $request The current HTTP request
     *
     * @return Response A response object representing the redirection to the list page after deletion
     *
     * @throws AccessDeniedException If the user does not have the ROLE_ADMIN role
     */

    #[Route(path: '/admin/Parcours/{id}/supprimer', name: 'app_admin_parcours_delete', requirements: ['id' => '\d+'])]
    public function delete(Parcours $Parcours, EntityManagerInterface $entityManager, Request $request): Response
    {

        if ($this->isCsrfTokenValid('delete' . $Parcours->getId(), $request->request->get('_token'))) {
            $entityManager->remove($Parcours);
            $entityManager->flush();
            $this->addFlash('success', "");
        }

        return $this->redirectToRoute('app_admin_parcours');
    }
}
