<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;

/**
 * BookNotFoundException - Exception thrown when a book is not found
 */
class BookNotFoundException extends Exception
{
    public function __construct(int $bookId)
    {
        parent::__construct(sprintf('Book with ID %d not found', $bookId));
    }
}
