<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\DTO\BookDTO;
use App\Application\DTO\PersonDTO;
use App\Domain\Repository\BookRepositoryInterface;

/**
 * SearchBooksUseCase - Use case for searching books
 */
class SearchBooksUseCase
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Ejecuta la búsqueda de libros
     *
     * @param string $searchQuery
     * @return BookDTO[]
     */
    public function execute(string $searchQuery): array
    {
        $books = $this->bookRepository->searchBooks($searchQuery);

        return array_map(function ($book) {
            $authors = array_map(
                fn ($person) => new PersonDTO(
                    $person->getName(),
                    $person->getBirthYear(),
                    $person->getDeathYear()
                ),
                $book->getAuthors()
            );

            return new BookDTO(
                $book->getId(),
                $book->getTitle(),
                $book->getSubjects(),
                $authors
            );
        }, $books);
    }
}
