<?php

declare(strict_types=1);

namespace App\Application\DTO;

/**
 * PersonDTO - Data Transfer Object for authors
 */
class PersonDTO
{
    public string $name;
    public ?int $birthYear;
    public ?int $deathYear;

    public function __construct(string $name, ?int $birthYear = null, ?int $deathYear = null)
    {
        $this->name = $name;
        $this->birthYear = $birthYear;
        $this->deathYear = $deathYear;
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
