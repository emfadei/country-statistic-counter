<?php

namespace App\Application\Query;

interface PaginationParametersInterface
{
    public function getPagination(): Pagination;

    public function setPagination(Pagination $pagination): void;
}
