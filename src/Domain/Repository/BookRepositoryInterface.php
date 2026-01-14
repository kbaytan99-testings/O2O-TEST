<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Book;

/**
 * BookRepositoryInterface - Contract for the books repository
 */
interface BookRepositoryInterface
{
    /**
     * Busca libros por una cadena de búsqueda
     *
     * @param string $searchQuery
     * @return Book[]
     */
    public function searchBooks(string $searchQuery): array;

    /**
     * Obtiene un libro por su ID
     *
     * @param int $id
     * @return Book|null
     */
    public function findById(int $id): ?Book;
}
