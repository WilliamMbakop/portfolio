<?php

namespace App\Service;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Stichoza\GoogleTranslate\GoogleTranslate;

class RssFeedService
{
    private $client;
    private $cachePool;

    // Injection de dépendances pour HttpClient et Cache Pool
    public function __construct(HttpClientInterface $client, CacheItemPoolInterface $cachePool)
    {
        $this->client = $client;
        $this->cachePool = $cachePool;
    }

    public function fetchRssFeed(string $url): array
    {
        // Tentative de récupération des données depuis le cache
        $cacheItem = $this->cachePool->getItem('rss_feed_' . md5($url));

        // Si le cache contient les données, on les retourne directement
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        // Sinon, on récupère et parse le flux RSS
        $response = $this->client->request('GET', $url);
        $content = $response->getContent();
        $xml = simplexml_load_string($content);

        // Initialisation du traducteur
        $translator = new GoogleTranslate('fr');

        // Parsing des articles du flux RSS
        $items = [];
        foreach ($xml->channel->item as $item) {
            $title = (string) $item->title;
            $description = (string) $item->description;

            // Traduction des titres et descriptions en français
            $translatedTitle = $translator->translate($title);
            $translatedDescription = $translator->translate($description);

            $items[] = [
                'title' => $translatedTitle,
                'link' => (string) $item->link,
                'description' => $translatedDescription,
                'pubDate' => (string) $item->pubDate,
            ];
        }

        // Tri des articles du plus récent au plus ancien
        usort($items, function ($a, $b) {
            return strtotime($b['pubDate']) - strtotime($a['pubDate']);
        });

        // Mise en cache des données pendant 1 heure
        $cacheItem->set($items);
        $cacheItem->expiresAfter(3600); // expire après 1 heure
        $this->cachePool->save($cacheItem);

        return $items;
    }
}
