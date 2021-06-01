<?php

namespace App\Application\Query;

class FindUserCollectionQuery implements PaginationParametersInterface
{
    public ?string $name = null;

    public Pagination $pagination;

    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    public function setPagination(Pagination $pagination): void
    {
        $this->pagination = $pagination;
    }
}
