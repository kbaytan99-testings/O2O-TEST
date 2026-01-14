<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase;

use App\Application\UseCase\GetBookByIdUseCase;
use App\Domain\Entity\Book;
use App\Domain\Entity\Person;
use App\Domain\Exception\BookNotFoundException;
use App\Domain\Repository\BookRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * GetBookByIdUseCaseTest - Tests unitarios para GetBookByIdUseCase con mock
 */
class GetBookByIdUseCaseTest extends TestCase
{
    public function testExecuteReturnsBook(): void
    {
        $mockRepository = $this->createMock(BookRepositoryInterface::class);

        $author = new Person('Homer', null, null);
        $book = new Book(
            100,
            'The Odyssey',
            ['Epic', 'Poetry'],
            [$author]
        );

        $mockRepository->expects($this->once())
            ->method('findById')
            ->with(100)
            ->willReturn($book);

        $useCase = new GetBookByIdUseCase($mockRepository);
        $result = $useCase->execute(100);

        $this->assertSame(100, $result->id);
        $this->assertSame('The Odyssey', $result->title);
        $this->assertCount(1, $result->authors);
        $this->assertSame('Homer', $result->authors[0]->name);
    }

    public function testExecuteThrowsExceptionWhenBookNotFound(): void
    {
        $mockRepository = $this->createMock(BookRepositoryInterface::class);

        $mockRepository->expects($this->once())
            ->method('findById')
            ->with(999)
            ->willReturn(null);

        $useCase = new GetBookByIdUseCase($mockRepository);

        $this->expectException(BookNotFoundException::class);
        $this->expectExceptionMessage('Book with ID 999 not found');

        $useCase->execute(999);
    }
}
