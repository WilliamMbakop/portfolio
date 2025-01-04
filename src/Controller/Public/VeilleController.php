<?php

namespace App\Controller\Public;

use App\Repository\VeilleRepository;
use App\Repository\SocialNetworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\RssFeedService;

class VeilleController extends AbstractController
{

    private $rssFeedService;

    public function __construct(RssFeedService $rssFeedService)
    {
        $this->rssFeedService = $rssFeedService;
    }

    #[Route('/veille', name: 'app_public_veille_index')]
    public function index(
        Request $request,
        SocialNetworkRepository $socialNetworkRepository,
        VeilleRepository $veilleRepository,
    ): response {

        $firstVeillesUrl = $veilleRepository->findFirstByIdAsc();
        $url = $firstVeillesUrl->getUrl();

        // On récupère le flux RSS
        $items = $this->rssFeedService->fetchRssFeed($url);

        $template = 'public/fragments/body/veille/_index.html.twig';

        return $this->render($template, [
            'socialnetworks' => $socialNetworkRepository->findAll(),
            'veilles' => $veilleRepository->findBy([], ['name' => 'ASC']),
            'items' => $items,
        ]);
    }


    #[Route('/veille/show', name: 'app_public_veille_show')]
    public function _show(
        Request $request,
        VeilleRepository $veilleRepository,
        SocialNetworkRepository $socialNetworkRepository,
    ): response {
        $veilleID = $request->query->get('veilleID');
        $veille = $veilleRepository->findOneById($veilleID);
        $veilleUrl = $veille->getUrl();
        $items = $this->rssFeedService->fetchRssFeed($veilleUrl);

        $template = 'public/fragments/body/veille/_content.html.twig';

        return $this->render($template, [
            'socialnetworks' => $socialNetworkRepository->findAll(),
            'items' => $items,
            'veilleID' => $veilleID,

        ]);
    }
}
