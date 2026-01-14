<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase;

use App\Application\UseCase\SearchBooksUseCase;
use App\Domain\Entity\Book;
use App\Domain\Entity\Person;
use App\Domain\Repository\BookRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * SearchBooksUseCaseTest - Tests unitarios para SearchBooksUseCase con mock
 */
class SearchBooksUseCaseTest extends TestCase
{
    public function testExecuteReturnsBooks(): void
    {
        // Mock del repositorio
        $mockRepository = $this->createMock(BookRepositoryInterface::class);

        $author = new Person('Miguel de Cervantes', 1547, 1616);
        $book = new Book(
            1,
            'Don Quixote',
            ['Fiction', 'Adventure'],
            [$author]
        );

        $mockRepository->expects($this->once())
            ->method('searchBooks')
            ->with('Quixote')
            ->willReturn([$book]);

        // Caso de uso
        $useCase = new SearchBooksUseCase($mockRepository);
        $result = $useCase->execute('Quixote');

        $this->assertCount(1, $result);
        $this->assertSame(1, $result[0]->id);
        $this->assertSame('Don Quixote', $result[0]->title);
        $this->assertCount(1, $result[0]->authors);
        $this->assertSame('Miguel de Cervantes', $result[0]->authors[0]->name);
    }

    public function testExecuteReturnsEmptyArray(): void
    {
        $mockRepository = $this->createMock(BookRepositoryInterface::class);

        $mockRepository->expects($this->once())
            ->method('searchBooks')
            ->with('NonexistentBook')
            ->willReturn([]);

        $useCase = new SearchBooksUseCase($mockRepository);
        $result = $useCase->execute('NonexistentBook');

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }
}
