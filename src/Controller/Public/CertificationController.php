<?php

namespace App\Controller\Public;

use App\Repository\CertificationRepository;
use App\Repository\SocialNetworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CertificationController extends AbstractController
{

    #[Route('/certification', name: 'app_public_certification_index')]
    public function index(
        Request $request,
        CertificationRepository $certificationRepository,
        SocialNetworkRepository $socialNetworkRepository,
    ): response {

        $template = 'public/fragments/body/certification/index.html.twig';

        return $this->render($template, [
            'certifications' => $certificationRepository->findAll(),
            'socialnetworks' => $socialNetworkRepository->findAll(),
        ]);
    }
}
