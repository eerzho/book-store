<?php

namespace App\Tests\Controller;

use App\Entity\BookCategory;
use App\Tests\AbstractControllerTest;

class BookCategoryControllerTest extends AbstractControllerTest
{
    public function testCategories()
    {
        $this->entityManager->persist((new BookCategory())
            ->setTitle('Category 1')
            ->setSlug('category-1'));
        $this->entityManager->flush();

        $this->client->request('GET', '/api/v1/books/category');
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
                        'required' => ['id', 'title', 'slug'],
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'title' => ['type' => 'string'],
                            'slug' => ['type' => 'string'],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
