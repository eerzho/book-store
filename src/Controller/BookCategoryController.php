<?php

namespace App\Controller;

use App\Model\BookCategoryListResponse;
use App\Service\BookCategoryService;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;

class BookCategoryController extends AbstractController
{
    public function __construct(private BookCategoryService $bookCategoryService)
    {
    }

    #[Route('/book/category', name: 'app_book_category')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/BookCategoryController.php',
        ]);
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Return book categories",
     *     @Model(type=BookCategoryListResponse::class)
     * )
     */
    #[Route(path: '/api/v1/books/category', methods: 'GET')]
    public function categories(): Response
    {
        return $this->json($this->bookCategoryService->getCategories());
    }
}
