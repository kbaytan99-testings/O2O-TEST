<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Client;

use App\Infrastructure\Client\GutendexClient;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * GutendexClientTest - Tests unitarios para GutendexClient con mocks
 */
class GutendexClientTest extends TestCase
{
    public function testSearchBooksReturnsData(): void
    {
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('toArray')
            ->willReturn([
                'results' => [
                    [
                        'id' => 1,
                        'title' => 'Test Book',
                        'subjects' => ['Fiction'],
                        'authors' => [
                            ['name' => 'Test Author', 'birth_year' => 1900, 'death_year' => 1980],
                        ],
                    ],
                ],
            ]);

        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $mockHttpClient->expects($this->once())
            ->method('request')
            ->with('GET', 'https://gutendex.com/books', [
                'query' => ['search' => 'test'],
            ])
            ->willReturn($mockResponse);

        $mockCacheItem = $this->createMock(CacheItemInterface::class);
        $mockCacheItem->method('isHit')->willReturn(false);
        $mockCacheItem->method('set')->willReturnSelf();
        $mockCacheItem->method('expiresAfter')->willReturnSelf();

        $mockCache = $this->createMock(CacheItemPoolInterface::class);
        $mockCache->method('getItem')->willReturn($mockCacheItem);
        $mockCache->method('save')->willReturn(true);

        $client = new GutendexClient($mockHttpClient, 'https://gutendex.com', $mockCache, 3600);
        $result = $client->searchBooks('test');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('results', $result);
    }

    public function testGetBookByIdReturnsData(): void
    {
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('toArray')
            ->willReturn([
                'id' => 1,
                'title' => 'Test Book',
                'subjects' => ['Fiction'],
                'authors' => [
                    ['name' => 'Test Author', 'birth_year' => 1900, 'death_year' => 1980],
                ],
            ]);

        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $mockHttpClient->expects($this->once())
            ->method('request')
            ->with('GET', 'https://gutendex.com/books/1')
            ->willReturn($mockResponse);

        $mockCacheItem = $this->createMock(CacheItemInterface::class);
        $mockCacheItem->method('isHit')->willReturn(false);
        $mockCacheItem->method('set')->willReturnSelf();
        $mockCacheItem->method('expiresAfter')->willReturnSelf();

        $mockCache = $this->createMock(CacheItemPoolInterface::class);
        $mockCache->method('getItem')->willReturn($mockCacheItem);
        $mockCache->method('save')->willReturn(true);

        $client = new GutendexClient($mockHttpClient, 'https://gutendex.com', $mockCache, 3600);
        $result = $client->getBookById(1);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('id', $result);
        $this->assertSame(1, $result['id']);
    }

    public function testSearchBooksUsesCachedData(): void
    {
        $cachedData = [
            'results' => [
                ['id' => 1, 'title' => 'Cached Book'],
            ],
        ];

        $mockCacheItem = $this->createMock(CacheItemInterface::class);
        $mockCacheItem->method('isHit')->willReturn(true);
        $mockCacheItem->method('get')->willReturn($cachedData);

        $mockCache = $this->createMock(CacheItemPoolInterface::class);
        $mockCache->method('getItem')->willReturn($mockCacheItem);

        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $mockHttpClient->expects($this->never())->method('request');

        $client = new GutendexClient($mockHttpClient, 'https://gutendex.com', $mockCache, 3600);
        $result = $client->searchBooks('test');

        $this->assertSame($cachedData, $result);
    }
}
