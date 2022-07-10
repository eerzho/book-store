<?php

namespace App\Tests\Service;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Exception\BookCategoryNotFoundException;
use App\Model\Book\BookListItem;
use App\Model\Book\BookListResponse;
use App\Repository\BookCategoryRepository;
use App\Repository\BookRepository;
use App\Service\BookService;
use App\Tests\AbstractTestCase;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class BookServiceTest extends AbstractTestCase
{
    public function testGetBooksByCategoryNotFound(): void
    {
        $bookRepository = $this->createMock(BookRepository::class);
        $bookCategoryRepository = $this->createMock(BookCategoryRepository::class);
        $bookCategoryRepository->expects($this->once())
            ->method('find')
            ->with(130)
            ->willThrowException(new BookCategoryNotFoundException());

        $this->expectException(BookCategoryNotFoundException::class);

        (new BookService($bookRepository, $bookCategoryRepository))->getBooksByCategory(130);
    }

    public function testGetBooksByCategory(): void
    {
        $bookRepository = $this->createMock(BookREpository::class);
        $bookRepository->expects($this->once())
            ->method('findBooksByCategoryId')
            ->with(130)
            ->willReturn([$this->createBookEntity()]);

        $bookCategoryRepository = $this->createMock(BookCategoryRepository::class);
        $bookCategoryRepository->expects($this->once())
            ->method('find')
            ->with(130)
            ->willReturn(new BookCategory());

        $service = new BookService($bookRepository, $bookCategoryRepository);
        $expected = new BookListResponse([$this->createBookItemModel()]);
        $this->assertEquals($expected, $service->getBooksByCategory(130));
    }

    private function createBookEntity(): Book
    {
        $book = (new Book())
            ->setTitle('Test')
            ->setSlug('test')
            ->setMeap(false)
            ->setAuthors(['Testov Test'])
            ->setImage('test.png')
            ->setCategories(new ArrayCollection())
            ->setPublishDate(new DateTime('2022-07-10'));

        $this->setEntityId($book, 130);

        return $book;
    }

    private function createBookItemModel(): BookListItem
    {
        return (new BookListItem())
            ->setId(130)
            ->setTitle('Test')
            ->setSlug('test')
            ->setMeap(false)
            ->setAuthors(['Testov Test'])
            ->setImage('test.png')
            ->setPublishDate(1657411200);
    }
}
