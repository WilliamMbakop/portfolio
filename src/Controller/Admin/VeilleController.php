<?php

namespace App\Controller\Admin;

use App\Entity\Veille;
use App\Form\VeilleType;
use App\Repository\VeilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class VeilleController extends AbstractController
{
    #[Route('/admin/veille', name: 'app_admin_veille')]
    public function index(Request $request, VeilleRepository $veilleRepository): response
    {

        $template = $request->get('ajax') ? 'admin/veille/_list.html.twig' : 'admin/veille/index.html.twig';

        return $this->render($template, [
            'veilles' => $veilleRepository->findAll(),
            'title' => 'Admin | Veille technologique'
        ]);
    }

    /**
     * Add a new Veille entity.
     *
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the new entity.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */
    #[Route(path: '/admin/veille/ajouter', name: 'app_admin_veille_add')]
    public function add(EntityManagerInterface $entityManager, Request $request): Response
    {

        $veille = new Veille();
        $form = $this->createForm(VeilleType::class, $veille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($veille);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");
                return new Response(null, 204);
            }
        }

        $template = 'admin/veille/_add.html.twig';

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
     * Edit Veille entity.
     *
     * @param Veille $Veille The Veille entity to edit.
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the changes.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */

    #[Route(path: '/admin/veille/{id}/modifier', name: 'app_admin_veille_edit', requirements: ['id' => '\d+'])]
    public function edit(Veille $veille, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(VeilleType::class, $veille);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");

                return new Response(null, 204);
            }

            return $this->redirectToRoute('app_admin_veille');
        }

        return $this->render('admin/veille/_add.html.twig', [
            'form' => $form,
        ]);
    }



    /**
     * Delete a Veille
     *
     * @param Veille $Veille The Veille to be deleted
     * @param EntityManagerInterface $entityManager The entity manager used for database operations
     * @param Request $request The current HTTP request
     *
     * @return Response A response object representing the redirection to the list page after deletion
     *
     * @throws AccessDeniedException If the user does not have the ROLE_ADMIN role
     */

    #[Route(path: '/admin/veille/{id}/supprimer', name: 'app_admin_veille_delete', requirements: ['id' => '\d+'])]
    public function delete(Veille $Veille, EntityManagerInterface $entityManager, Request $request): Response
    {

        if ($this->isCsrfTokenValid('delete' . $Veille->getId(), $request->request->get('_token'))) {
            $entityManager->remove($Veille);
            $entityManager->flush();
            $this->addFlash('success', "");
        }

        return $this->redirectToRoute('app_admin_veille');
    }
}
