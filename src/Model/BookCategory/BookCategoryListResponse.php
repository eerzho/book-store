<?php

namespace App\Model\BookCategory;

class BookCategoryListResponse
{
    /**
     * @var BookCategoryListItem[]
     */
    private array $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return BookCategoryListItem[]
     */
    public function getData(): array
    {
        return $this->data;
    }
}
