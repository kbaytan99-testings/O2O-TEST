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
use OpenApi\Annotations as OA;

/**
 * BookController - REST controller for the books API
 *
 * @Route("/books", name="api_books_")
 * @OA\Tag(name="Books")
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
     * @OA\Get(
     *     path="/api/books",
     *     summary="Search books",
     *     description="Search books by a query string from the Gutendex API",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search query string",
     *         required=true,
     *         @OA\Schema(type="string", example="shakespeare")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of books matching the search query",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1342),
     *                 @OA\Property(property="title", type="string", example="Pride and Prejudice"),
     *                 @OA\Property(property="subjects", type="array", @OA\Items(type="string")),
     *                 @OA\Property(
     *                     property="authors",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="name", type="string"),
     *                         @OA\Property(property="birthYear", type="integer", nullable=true),
     *                         @OA\Property(property="deathYear", type="integer", nullable=true)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request - search parameter is required",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Search parameter is required")
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/books/{id}",
     *     summary="Get book by ID",
     *     description="Get detailed information about a specific book by its Gutendex ID",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Book ID from Project Gutenberg",
     *         required=true,
     *         @OA\Schema(type="integer", example=1342)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1342),
     *             @OA\Property(property="title", type="string", example="Pride and Prejudice"),
     *             @OA\Property(property="subjects", type="array", @OA\Items(type="string")),
     *             @OA\Property(
     *                 property="authors",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="name", type="string", example="Austen, Jane"),
     *                     @OA\Property(property="birthYear", type="integer", example=1775, nullable=true),
     *                     @OA\Property(property="deathYear", type="integer", example=1817, nullable=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Book with ID 999999 not found")
     *         )
     *     )
     * )
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
