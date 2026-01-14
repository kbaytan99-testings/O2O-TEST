<?php

declare(strict_types=1);

namespace App\Infrastructure\Client;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * GutendexClient - HTTP client for communicating with the Gutendex API
 */
class GutendexClient
{
    private HttpClientInterface $httpClient;
    private string $baseUrl;
    private CacheItemPoolInterface $cache;
    private int $cacheTtl;

    public function __construct(
        HttpClientInterface $httpClient,
        string $baseUrl,
        CacheItemPoolInterface $cache,
        int $cacheTtl = 3600
    ) {
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
        $this->cache = $cache;
        $this->cacheTtl = $cacheTtl;
    }

    /**
     * Search books in Gutendex
     *
     * @param string $searchQuery
     * @return array<string, mixed>
     */
    public function searchBooks(string $searchQuery): array
    {
        $cacheKey = 'gutendex_search_' . md5($searchQuery);
        $cachedItem = $this->cache->getItem($cacheKey);

        if ($cachedItem->isHit()) {
            return $cachedItem->get();
        }

        $response = $this->httpClient->request('GET', $this->baseUrl, [
            'query' => [
                'search' => $searchQuery,
            ],
        ]);

        $data = $response->toArray();

        $cachedItem->set($data);
        $cachedItem->expiresAfter($this->cacheTtl);
        $this->cache->save($cachedItem);

        return $data;
    }

    /**
     * Get a book by its ID
     *
     * @param int $id
     * @return array<string, mixed>|null
     */
    public function getBookById(int $id): ?array
    {
        $cacheKey = 'gutendex_book_' . $id;
        $cachedItem = $this->cache->getItem($cacheKey);

        if ($cachedItem->isHit()) {
            return $cachedItem->get();
        }

        try {
            $response = $this->httpClient->request('GET', $this->baseUrl . '/' . $id);
            $data = $response->toArray();

            $cachedItem->set($data);
            $cachedItem->expiresAfter($this->cacheTtl);
            $this->cache->save($cachedItem);

            return $data;
        } catch (\Exception $e) {
            return null;
        }
    }
}
