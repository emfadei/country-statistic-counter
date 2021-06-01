<?php

namespace App\Application\UseCase;

use App\Application\Response\CollectionResponse;
use App\Domain\Repository\CountryStatisticRepositoryInterface;

class FindCountryStatisticCollection
{
    private CountryStatisticRepositoryInterface $countryStatisticRepository;

    public function __construct(CountryStatisticRepositoryInterface $countryStatisticRepository)
    {
        $this->countryStatisticRepository = $countryStatisticRepository;
    }

    public function handle(): CollectionResponse
    {
        $items = $this->countryStatisticRepository->getAll();

        return new CollectionResponse($items->toArray(), $items->count());
    }
}
