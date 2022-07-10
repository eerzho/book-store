<?php

namespace App\Model\Book;

class BookListResponse
{
    /**
     * @var BookListItem[]
     */
    private array $data;

    /**
     * @param BookListItem[] $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return BookListItem[]
     */
    public function getData(): array
    {
        return $this->data;
    }
}
