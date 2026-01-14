<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\DTO\BookDTO;
use App\Application\DTO\PersonDTO;
use App\Domain\Exception\BookNotFoundException;
use App\Domain\Repository\BookRepositoryInterface;

/**
 * GetBookByIdUseCase - Use case for getting a book by ID
 */
class GetBookByIdUseCase
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Ejecuta la obtención de un libro por ID
     *
     * @param int $id
     * @return BookDTO
     * @throws BookNotFoundException
     */
    public function execute(int $id): BookDTO
    {
        $book = $this->bookRepository->findById($id);

        if ($book === null) {
            throw new BookNotFoundException($id);
        }

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
    }
}
