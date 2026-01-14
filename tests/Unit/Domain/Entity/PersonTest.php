<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\Person;
use PHPUnit\Framework\TestCase;

/**
 * PersonTest - Tests unitarios para la entidad Person
 */
class PersonTest extends TestCase
{
    public function testPersonCanBeCreated(): void
    {
        $person = new Person('Charles Dickens', 1812, 1870);

        $this->assertSame('Charles Dickens', $person->getName());
        $this->assertSame(1812, $person->getBirthYear());
        $this->assertSame(1870, $person->getDeathYear());
    }

    public function testPersonWithNullDates(): void
    {
        $person = new Person('Anonymous Author');

        $this->assertSame('Anonymous Author', $person->getName());
        $this->assertNull($person->getBirthYear());
        $this->assertNull($person->getDeathYear());
    }

    public function testPersonToArray(): void
    {
        $person = new Person('Oscar Wilde', 1854, 1900);
        $array = $person->toArray();

        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('birth_year', $array);
        $this->assertArrayHasKey('death_year', $array);
        $this->assertSame('Oscar Wilde', $array['name']);
        $this->assertSame(1854, $array['birth_year']);
        $this->assertSame(1900, $array['death_year']);
    }
}
