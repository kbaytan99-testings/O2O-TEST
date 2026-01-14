<?php

declare(strict_types=1);

namespace App\Domain\Entity;

/**
 * Book Entity - Represents a book in the domain
 */
class Book
{
    private int $id;
    private string $title;
    /** @var string[] */
    private array $subjects;
    /** @var Person[] */
    private array $authors;

    /**
     * @param int $id
     * @param string $title
     * @param string[] $subjects
     * @param Person[] $authors
     */
    public function __construct(int $id, string $title, array $subjects, array $authors)
    {
        $this->id = $id;
        $this->title = $title;
        $this->subjects = $subjects;
        $this->authors = $authors;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string[]
     */
    public function getSubjects(): array
    {
        return $this->subjects;
    }

    /**
     * @return Person[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * Convert the entity to an array for JSON response
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subjects' => $this->subjects,
            'authors' => array_map(fn (Person $person) => $person->toArray(), $this->authors),
        ];
    }
}
