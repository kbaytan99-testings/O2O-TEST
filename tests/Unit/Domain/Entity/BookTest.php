<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\Book;
use App\Domain\Entity\Person;
use PHPUnit\Framework\TestCase;

/**
 * BookTest - Tests unitarios para la entidad Book
 */
class BookTest extends TestCase
{
    public function testBookCanBeCreated(): void
    {
        $author = new Person('William Shakespeare', 1564, 1616);
        $book = new Book(
            1,
            'Hamlet',
            ['Drama', 'Tragedy'],
            [$author]
        );

        $this->assertSame(1, $book->getId());
        $this->assertSame('Hamlet', $book->getTitle());
        $this->assertSame(['Drama', 'Tragedy'], $book->getSubjects());
        $this->assertCount(1, $book->getAuthors());
        $this->assertSame('William Shakespeare', $book->getAuthors()[0]->getName());
    }

    public function testBookToArray(): void
    {
        $author = new Person('Jane Austen', 1775, 1817);
        $book = new Book(
            2,
            'Pride and Prejudice',
            ['Romance', 'Classic'],
            [$author]
        );

        $array = $book->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('title', $array);
        $this->assertArrayHasKey('subjects', $array);
        $this->assertArrayHasKey('authors', $array);
        $this->assertSame(2, $array['id']);
        $this->assertSame('Pride and Prejudice', $array['title']);
        $this->assertIsArray($array['authors']);
        $this->assertCount(1, $array['authors']);
    }
}
