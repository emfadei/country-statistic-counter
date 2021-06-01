<?php

namespace App\Application\Response;

use App\Application\Query\Pagination;
use Ramsey\Collection\AbstractArray;

class CollectionResponse extends AbstractArray
{
    private int $totalItems;

    private ?Pagination $pagination;

    private array $meta = [];

    public function __construct(array $data, int $totalItems, ?Pagination $pagination = null)
    {
        parent::__construct($data);

        $this->totalItems = $totalItems;
        $this->pagination = $pagination;
    }

    public function getItems(): array
    {
        return $this->data;
    }

    public function getTotalItems(): float
    {
        return $this->totalItems;
    }

    public function getLastPage(): float
    {
        return ceil($this->totalItems / $this->pagination->getItemsPerPage());
    }

    public function getCurrentPage(): float
    {
        return $this->pagination->getPage();
    }

    public function getItemsPerPage(): float
    {
        return $this->pagination->getItemsPerPage();
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function setMeta(string $name, $value): void
    {
        $this->meta[$name] = $value;
    }
}
