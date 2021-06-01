<?php

namespace App\Infrastructure\Api\WebApi\Action;

use App\Application\Services\Responder;
use App\Application\UseCase\FindCountryStatisticCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetCountryStatisticCollectionAction
{
    private FindCountryStatisticCollection $findCountryStatisticCollection;

    private Responder $responder;

    public function __construct(FindCountryStatisticCollection $findCountryStatisticCollection, Responder $responder)
    {
        $this->findCountryStatisticCollection = $findCountryStatisticCollection;
        $this->responder                      = $responder;
    }

    /**
     * @Route(
     *     methods={"GET"},
     *     path="/api/countries-statistic"
     * )
     */
    public function __invoke(Request $request): Response
    {
        $responseData = $this->findCountryStatisticCollection->handle();

        return $this->responder->createResponse($responseData);
    }
}
