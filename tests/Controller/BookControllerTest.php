<?php

namespace App\Tests\Controller;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Tests\AbstractControllerTest;
use Doctrine\Common\Collections\ArrayCollection;

class BookControllerTest extends AbstractControllerTest
{
    public function testBooksByCategory()
    {
        $this->client->request('GET', '/api/v1/category/'.$this->createBookCategory().'/books');
        $responseContent = $this->client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['data'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'title', 'slug', 'image', 'authors', 'meap', 'publishDate'],
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'title' => ['type' => 'string'],
                            'slug' => ['type' => 'string'],
                            'image' => ['type' => 'string'],
                            'authors' => [
                                'type' => 'array',
                                'items' => ['type' => 'string'],
                            ],
                            'meap' => ['type' => 'boolean'],
                            'publishDate' => ['type' => 'integer'],
                        ],
                    ],
                ],
            ],
        ]);
    }

    private function createBookCategory(): int
    {
        $bookCategory = (new BookCategory())->setTitle('Category 1')->setSlug('category-1');
        $this->entityManager->persist($bookCategory);

        $this->entityManager->persist((new Book())
            ->setTitle('Book 1')
            ->setSlug('book-1')
            ->setImage('test.png')
            ->setAuthors(['Testov Test'])
            ->setMeap(false)
            ->setCategories(new ArrayCollection([$bookCategory]))
            ->setPublishDate(new \DateTime())
        );

        $this->entityManager->flush();

        return $bookCategory->getId();
    }
}
