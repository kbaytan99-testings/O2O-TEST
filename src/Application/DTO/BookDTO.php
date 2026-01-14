<?php

declare(strict_types=1);

namespace App\Application\DTO;

/**
 * BookDTO - Data Transfer Object for books
 */
class BookDTO
{
    public int $id;
    public string $title;
    /** @var string[] */
    public array $subjects;
    /** @var PersonDTO[] */
    public array $authors;

    /**
     * @param int $id
     * @param string $title
     * @param string[] $subjects
     * @param PersonDTO[] $authors
     */
    public function __construct(int $id, string $title, array $subjects, array $authors)
    {
        $this->id = $id;
        $this->title = $title;
        $this->subjects = $subjects;
        $this->authors = $authors;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subjects' => $this->subjects,
            'authors' => array_map(fn (PersonDTO $person) => $person->toArray(), $this->authors),
        ];
    }
}
