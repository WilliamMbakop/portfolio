<?php

namespace App\Controller\Admin;

use App\Entity\Presentation;
use App\Form\PresentationType;
use App\Repository\PresentationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class PresentationController extends AbstractController
{
    #[Route('/admin/presentation', name: 'app_admin_presentation')]
    public function index(Request $request, PresentationRepository $presentationRepository): response
    {

        $template = $request->get('ajax') ? 'admin/presentation/_list.html.twig' : 'admin/presentation/index.html.twig';

        return $this->render($template, [
            'presentations' => $presentationRepository->findAll(),
            'title' => 'Admin | Présentations'
        ]);
    }

    /**
     * Add a new Presentation entity.
     *
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the new entity.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */
    #[Route(path: '/admin/presentation/ajouter', name: 'app_admin_presentation_add')]
    public function add(EntityManagerInterface $entityManager, Request $request): Response
    {

        $presentation = new Presentation();
        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($presentation);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");
                return new Response(null, 204);
            }
        }

        $template = 'admin/presentation/_add.html.twig';

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
     * Edit Presentation entity.
     *
     * @param presentation $presentation The presentation entity to edit.
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the changes.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */

    #[Route(path: '/admin/presentation/{id}/modifier', name: 'app_admin_presentation_edit', requirements: ['id' => '\d+'])]
    public function edit(Presentation $presentation, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(presentationType::class, $presentation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");

                return new Response(null, 204);
            }

            return $this->redirectToRoute('app_admin_presentation');
        }

        return $this->render('admin/presentation/_add.html.twig', [
            'form' => $form,
        ]);
    }



    /**
     * Delete a presentation
     *
     * @param presentation $presentation The presentation to be deleted
     * @param EntityManagerInterface $entityManager The entity manager used for database operations
     * @param Request $request The current HTTP request
     *
     * @return Response A response object representing the redirection to the list page after deletion
     *
     * @throws AccessDeniedException If the user does not have the ROLE_ADMIN role
     */

    #[Route(path: '/admin/presentation/{id}/supprimer', name: 'app_admin_presentation_delete', requirements: ['id' => '\d+'])]
    public function delete(Presentation $presentation, EntityManagerInterface $entityManager, Request $request): Response
    {

        if ($this->isCsrfTokenValid('delete' . $presentation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($presentation);
            $entityManager->flush();
            $this->addFlash('success', "");
        }

        return $this->redirectToRoute('app_admin_presentation');
    }
}
