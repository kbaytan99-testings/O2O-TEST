<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Book;
use App\Domain\Entity\Person;
use App\Domain\Repository\BookRepositoryInterface;
use App\Infrastructure\Client\GutendexClient;

/**
 * GutendexBookRepository - Repository implementation using the Gutendex API
 */
class GutendexBookRepository implements BookRepositoryInterface
{
    private GutendexClient $client;

    public function __construct(GutendexClient $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function searchBooks(string $searchQuery): array
    {
        $data = $this->client->searchBooks($searchQuery);

        if (!isset($data['results']) || !is_array($data['results'])) {
            return [];
        }

        return array_map(
            fn (array $bookData) => $this->mapToBook($bookData),
            $data['results']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findById(int $id): ?Book
    {
        $data = $this->client->getBookById($id);

        if ($data === null) {
            return null;
        }

        return $this->mapToBook($data);
    }

    /**
     * Map API data to a Book entity
     *
     * @param array<string, mixed> $data
     * @return Book
     */
    private function mapToBook(array $data): Book
    {
        $authors = array_map(
            fn (array $authorData) => new Person(
                $authorData['name'] ?? '',
                $authorData['birth_year'] ?? null,
                $authorData['death_year'] ?? null
            ),
            $data['authors'] ?? []
        );

        return new Book(
            $data['id'] ?? 0,
            $data['title'] ?? '',
            $data['subjects'] ?? [],
            $authors
        );
    }
}
