<?php
// src/Service/RssFeedService.php
namespace App\Service;

use Psr\Cache\CacheItemPoolInterface as CacheCacheItemPoolInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Cache\Adapter\CacheItemPoolInterface;

class RssFeedService
{
    private $client;
    private $cachePool;

    // Injection de dépendances pour HttpClient et Cache Pool
    public function __construct(HttpClientInterface $client, CacheCacheItemPoolInterface $cachePool)
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

        // Parsing des articles du flux RSS
        $items = [];
        foreach ($xml->channel->item as $item) {
            $items[] = [
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'description' => (string) $item->description,
                'pubDate' => (string) $item->pubDate,
            ];
        }

        // Mise en cache des données pendant 1 heure
        $cacheItem->set($items);
        $cacheItem->expiresAfter(3600); // expire après 1 heure
        $this->cachePool->save($cacheItem);

        return $items;
    }
}
