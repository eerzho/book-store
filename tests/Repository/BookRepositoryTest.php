<?php

namespace App\Tests\Repository;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Repository\BookRepository;
use App\Tests\AbstractRepositoryTest;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class BookRepositoryTest extends AbstractRepositoryTest
{
    private BookRepository $bookRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = $this->getRepositoryForEntity(Book::class);
    }

    public function testFindBooksByCategoryId()
    {
        $category1 = (new BookCategory())->setTitle('Category 1')->setSlug('category-1');
        $this->entityManager->persist($category1);

        for ($i = 0; $i < 5; ++$i) {
            $book = $this->createBook('book-'.$i, $category1);
            $this->entityManager->persist($book);
        }

        $this->entityManager->flush();

        $this->assertCount(5, $this->bookRepository->findBooksByCategoryId($category1->getId()));
    }

    public function createBook(string $title, BookCategory $bookCategory): Book
    {
        return (new Book())
            ->setTitle($title)
            ->setSlug($title)
            ->setImage('test.png')
            ->setPublishDate(new DateTime())
            ->setCategories(new ArrayCollection([$bookCategory]))
            ->setAuthors(['Testov Test'])->setMeap(false);
    }
}
