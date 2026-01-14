<?php

declare(strict_types=1);

namespace App\Domain\Entity;

/**
 * Person Entity - Represents a book author
 */
class Person
{
    private ?int $birthYear;
    private ?int $deathYear;
    private string $name;

    public function __construct(string $name, ?int $birthYear = null, ?int $deathYear = null)
    {
        $this->name = $name;
        $this->birthYear = $birthYear;
        $this->deathYear = $deathYear;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBirthYear(): ?int
    {
        return $this->birthYear;
    }

    public function getDeathYear(): ?int
    {
        return $this->deathYear;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'birth_year' => $this->birthYear,
            'death_year' => $this->deathYear,
        ];
    }
}
