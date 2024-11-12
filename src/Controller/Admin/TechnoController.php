<?php

namespace App\Controller\Admin;

use App\Entity\Techno;
use App\Form\TechnoType;
use App\Repository\TechnoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class TechnoController extends AbstractController
{
    #[Route('/admin/techno', name: 'app_admin_techno')]
    public function index(Request $request, TechnoRepository $technoRepository): response
    {

        $template = $request->get('ajax') ? 'admin/techno/_list.html.twig' : 'admin/techno/index.html.twig';

        return $this->render($template, [
            'technos' => $technoRepository->findAll(),
            'title' => 'Admin | Technos'
        ]);
    }

    /**
     * Add a new Techno entity.
     *
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the new entity.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */
    #[Route(path: '/admin/techno/ajouter', name: 'app_admin_techno_add')]
    public function add(EntityManagerInterface $entityManager, Request $request): Response
    {

        $techno = new Techno();
        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($techno);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");
                return new Response(null, 204);
            }
        }

        $template = 'admin/techno/_add.html.twig';

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
     * Edit Techno entity.
     *
     * @param Techno $Techno The Techno entity to edit.
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the changes.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */

    #[Route(path: '/admin/techno/{id}/modifier', name: 'app_admin_techno_edit', requirements: ['id' => '\d+'])]
    public function edit(Techno $techno, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");

                return new Response(null, 204);
            }

            return $this->redirectToRoute('app_admin_techno');
        }

        return $this->render('admin/techno/_add.html.twig', [
            'form' => $form,
        ]);
    }



    /**
     * Delete a Techno
     *
     * @param Techno $Techno The Techno to be deleted
     * @param EntityManagerInterface $entityManager The entity manager used for database operations
     * @param Request $request The current HTTP request
     *
     * @return Response A response object representing the redirection to the list page after deletion
     *
     * @throws AccessDeniedException If the user does not have the ROLE_ADMIN role
     */

    #[Route(path: '/admin/techno/{id}/supprimer', name: 'app_admin_techno_delete', requirements: ['id' => '\d+'])]
    public function delete(Techno $Techno, EntityManagerInterface $entityManager, Request $request): Response
    {

        if ($this->isCsrfTokenValid('delete' . $Techno->getId(), $request->request->get('_token'))) {
            $entityManager->remove($Techno);
            $entityManager->flush();
            $this->addFlash('success', "");
        }

        return $this->redirectToRoute('app_admin_techno');
    }
}
