<?php

namespace App\Infrastructure\Serialization\Symfony;

class RequestContext
{
    public const DEFAULT_ITEMS_PER_PAGE = 20;

    private array $attributes;

    private array $customParameters;

    private string $normalizationClass;

    private array $normalizationContext;

    private int $itemsPerPage;

    public function __construct(
        array $attributes,
        string $normalizationClass,
        array $normalizationContext = [],
        array $customParameters = [],
        int $itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE
    ) {
        $this->attributes           = $attributes;
        $this->normalizationClass   = $normalizationClass;
        $this->normalizationContext = $normalizationContext;
        $this->customParameters     = $customParameters;
        $this->itemsPerPage         = $itemsPerPage;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getNormalizationClass(): string
    {
        return $this->normalizationClass;
    }

    public function getNormalizationContext(): array
    {
        return $this->normalizationContext;
    }

    public function getCustomParameters(): array
    {
        return $this->customParameters;
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }
}
