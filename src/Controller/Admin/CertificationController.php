<?php

namespace App\Controller\Admin;

use App\Entity\Certification;
use App\Form\CertificationType;
use App\Repository\CertificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CertificationController extends AbstractController
{
    #[Route('/admin/certification', name: 'app_admin_certification')]
    public function index(Request $request, CertificationRepository $certificationRepository): response
    {

        $template = $request->get('ajax') ? 'admin/certification/_list.html.twig' : 'admin/certification/index.html.twig';

        return $this->render($template, [
            'certifications' => $certificationRepository->findAll(),
        ]);
    }

    /**
     * Add a new Certification entity.
     *
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the new entity.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */
    #[Route(path: '/admin/certification/ajouter', name: 'app_admin_certification_add')]
    public function add(EntityManagerInterface $entityManager, Request $request): Response
    {

        $certification = new Certification();
        $form = $this->createForm(CertificationType::class, $certification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($certification);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");
                return new Response(null, 204);
            }
        }

        $template = 'admin/certification/add.html.twig';

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
     * Edit Certification entity.
     *
     * @param Certification $Certification The Certification entity to edit.
     * @param EntityManagerInterface $entityManager The entity manager responsible for persisting the changes.
     * @param Request $request The current request.
     *
     * @return Response The response object.
     *
     */

    #[Route(path: '/admin/certification/{id}/modifier', name: 'app_admin_certification_edit', requirements: ['id' => '\d+'])]
    public function edit(Certification $certification, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(CertificationType::class, $certification);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                $this->addFlash('success', "");

                return new Response(null, 204);
            }

            return $this->redirectToRoute('app_admin_certification');
        }

        return $this->render('admin/certification/add.html.twig', [
            'form' => $form,
        ]);
    }



    /**
     * Delete a Certification
     *
     * @param Certification $Certification The Certification to be deleted
     * @param EntityManagerInterface $entityManager The entity manager used for database operations
     * @param Request $request The current HTTP request
     *
     * @return Response A response object representing the redirection to the list page after deletion
     *
     * @throws AccessDeniedException If the user does not have the ROLE_ADMIN role
     */

    #[Route(path: '/admin/certification/{id}/supprimer', name: 'app_admin_certification_delete', requirements: ['id' => '\d+'])]
    public function delete(Certification $Certification, EntityManagerInterface $entityManager, Request $request): Response
    {

        if ($this->isCsrfTokenValid('delete' . $Certification->getId(), $request->request->get('_token'))) {
            $entityManager->remove($Certification);
            $entityManager->flush();
            $this->addFlash('success', "");
        }

        return $this->redirectToRoute('app_admin_certification');
    }
}
