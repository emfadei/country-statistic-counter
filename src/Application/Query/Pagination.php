<?php

namespace App\Application\Query;

use Symfony\Component\Validator\Constraints as Assert;

class Pagination
{
    public const DEFAULT_PAGE           = 1;
    public const DEFAULT_ITEMS_PER_PAGE = 20;

    /**
     * @Assert\Range(min="1")
     */
    private int $page;

    /**
     * @Assert\Range(min="1", max="100")
     */
    private int $itemsPerPage;

    public function __construct(int $page = self::DEFAULT_PAGE, int $itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE)
    {
        $this->page         = $page;
        $this->itemsPerPage = $itemsPerPage;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->itemsPerPage;
    }
}
