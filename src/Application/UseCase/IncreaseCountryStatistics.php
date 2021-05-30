<?php


namespace App\Application\UseCase;


use App\Application\Command\IncreaseCountryStatisticsCommand;
use App\Domain\Repository\CountryStatisticRepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class IncreaseCountryStatistics
{
    private CountryStatisticRepositoryInterface $countryStatisticRepository;

    private ValidatorInterface $validator;

    public function __construct(CountryStatisticRepositoryInterface $countryStatisticRepository, ValidatorInterface $validator)
    {
        $this->countryStatisticRepository = $countryStatisticRepository;
        $this->validator                  = $validator;
    }

    public function handle(IncreaseCountryStatisticsCommand $command): ?object
    {
        $result = null;

        $violations = $this->validator->validate($command);

        if ($violations->count() > 0) {
            $result = $violations;
        }

        $this->countryStatisticRepository->increaseByCode($command->countryCode);

        return $result;
    }
}