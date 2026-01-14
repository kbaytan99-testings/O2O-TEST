<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\UseCase\GetBookByIdUseCase;
use App\Application\UseCase\SearchBooksUseCase;
use App\Domain\Exception\BookNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * BookController - REST controller for the books API
 *
 * @Route("/books", name="api_books_")
 */
class BookController extends AbstractController
{
    private SearchBooksUseCase $searchBooksUseCase;
    private GetBookByIdUseCase $getBookByIdUseCase;

    public function __construct(
        SearchBooksUseCase $searchBooksUseCase,
        GetBookByIdUseCase $getBookByIdUseCase
    ) {
        $this->searchBooksUseCase = $searchBooksUseCase;
        $this->getBookByIdUseCase = $getBookByIdUseCase;
    }

    /**
     * Search books by query string
     *
     * @Route("", name="search", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $searchQuery = $request->query->get('search', '');

        if (empty($searchQuery)) {
            return $this->json(
                ['error' => 'Search parameter is required'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $books = $this->searchBooksUseCase->execute($searchQuery);

        return $this->json(
            array_map(fn ($book) => $book->toArray(), $books),
            Response::HTTP_OK
        );
    }

    /**
     * Get a book by its ID
     *
     * @Route("/{id}", name="show", methods={"GET"}, requirements={"id"="\d+"})
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $book = $this->getBookByIdUseCase->execute($id);

            return $this->json($book->toArray(), Response::HTTP_OK);
        } catch (BookNotFoundException $e) {
            return $this->json(
                ['error' => $e->getMessage()],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
