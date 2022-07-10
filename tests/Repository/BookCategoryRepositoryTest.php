<?php

namespace App\Tests\Repository;

use App\Entity\BookCategory;
use App\Repository\BookCategoryRepository;
use App\Tests\AbstractRepositoryTest;

class BookCategoryRepositoryTest extends AbstractRepositoryTest
{
    private BookCategoryRepository $bookCategoryRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookCategoryRepository = $this->getRepositoryForEntity(BookCategory::class);
    }

    public function testFindAllSortedByTitle()
    {
        $category3 = (new BookCategory())->setTitle('Category 3')->setSlug('category-3');
        $category2 = (new BookCategory())->setTitle('Category 2')->setSlug('category-2');
        $category1 = (new BookCategory())->setTitle('Category 1')->setSlug('category-1');

        foreach ([$category1, $category2, $category3] as $category) {
            $this->entityManager->persist($category);
        }

        $this->entityManager->flush();

        $titles = array_map(
            fn (BookCategory $bookCategory) => $bookCategory->getTitle(),
            $this->bookCategoryRepository->findAllSortedByTitle()
        );

        $this->assertEquals(['Category 1', 'Category 2', 'Category 3'], $titles);
    }
}
