<?php


namespace App\Domain\Repository;


use App\Application\Query\Pagination;

class UserSearchParameters
{
    private ?string $name;

    private Pagination $pagination;

    public function __construct(?string $name, Pagination $pagination)
    {
        $this->name = $name;
        $this->pagination = $pagination;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPagination(): Pagination
    {
        return $this->pagination;
    }
}