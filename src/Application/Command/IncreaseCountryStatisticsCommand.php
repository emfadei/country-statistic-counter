<?php


namespace App\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;

class IncreaseCountryStatisticsCommand
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="3")
     */
    public string $countryCode;
}