<?php

namespace App\Controller\Admin;

use App\Entity\SocialNetwork;
use App\Form\SocialNetworkType;
use App\Repository\SocialNetworkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class SocialNetworkController extends AbstractController
{
    #[Route('/admin/reseaux-sociaux', name: 'app_admin_socialnetwork')]
    public function index(Request $request, SocialNetworkRepository $socialnetworkRepository): response
    {

        $template = $request->get('ajax') ? 'admin/socialnetwork/_list.html.twig' : 'admin/socialnetwork/index.html.twig';

        return $this->render($template, [
            'socialnetworks' => $socialnetworkRepository->findAll(),
            'title' => 'Admin | Réseaux sociaux'
        ]);
    }

    /**
     * Add a new SocialNetwork entity.
     *
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the new entity.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */
    #[Route(path: '/admin/reseaux-sociaux/ajouter', name: 'app_admin_socialnetwork_add')]
    public function add(EntityManagerInterface $entityManager, Request $request): Response
    {

        $socialnetwork = new SocialNetwork();
        $form = $this->createForm(SocialNetworkType::class, $socialnetwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($socialnetwork);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");
                return new Response(null, 204);
            }
        }

        $template = 'admin/socialnetwork/_add.html.twig';

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
     * Edit SocialNetwork entity.
     *
     * @param SocialNetwork $SocialNetwork The SocialNetwork entity to edit.
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the changes.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */

    #[Route(path: '/admin/reseaux-sociaux/{id}/modifier', name: 'app_admin_socialnetwork_edit', requirements: ['id' => '\d+'])]
    public function edit(SocialNetwork $socialnetwork, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(SocialNetworkType::class, $socialnetwork);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");

                return new Response(null, 204);
            }

            return $this->redirectToRoute('app_admin_socialnetwork');
        }

        return $this->render('admin/socialnetwork/_add.html.twig', [
            'form' => $form,
        ]);
    }



    /**
     * Delete a SocialNetwork
     *
     * @param SocialNetwork $SocialNetwork The SocialNetwork to be deleted
     * @param EntityManagerInterface $entityManager The entity manager used for database operations
     * @param Request $request The current HTTP request
     *
     * @return Response A response object representing the redirection to the list page after deletion
     *
     * @throws AccessDeniedException If the user does not have the ROLE_ADMIN role
     */

    #[Route(path: '/admin/reseaux-sociaux/{id}/supprimer', name: 'app_admin_socialnetwork_delete', requirements: ['id' => '\d+'])]
    public function delete(SocialNetwork $SocialNetwork, EntityManagerInterface $entityManager, Request $request): Response
    {

        if ($this->isCsrfTokenValid('delete' . $SocialNetwork->getId(), $request->request->get('_token'))) {
            $entityManager->remove($SocialNetwork);
            $entityManager->flush();
            $this->addFlash('success', "");
        }

        return $this->redirectToRoute('app_admin_socialnetwork');
    }
}
