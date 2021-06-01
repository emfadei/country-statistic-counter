<?php

namespace App\Infrastructure\Api\WebApi\Action;

use App\Application\Command\IncreaseCountryStatisticsCommand;
use App\Application\Pipe\DeserializeRequestBody;
use App\Application\Services\Responder;
use App\Application\UseCase\IncreaseCountryStatistics;
use App\Infrastructure\Serialization\Symfony\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostCountryStatisticAction
{
    private IncreaseCountryStatistics $userCase;

    private DeserializeRequestBody $deserializeRequestBodyPipe;

    private Responder $responder;

    public function __construct(IncreaseCountryStatistics $userCase, DeserializeRequestBody $deserializeRequestBodyPipe, Responder $responder)
    {
        $this->userCase                   = $userCase;
        $this->deserializeRequestBodyPipe = $deserializeRequestBodyPipe;
        $this->responder                  = $responder;
    }

    /**
     * @Route(
     *     methods={"POST"},
     *     path="/api/countries-statistic",
     * )
     */
    public function __invoke(Request $request): Response
    {
        $requestContext = new RequestContext([], IncreaseCountryStatisticsCommand::class);
        $result         = $this->deserializeRequestBodyPipe->handle($request, $requestContext);

        if ($result->hasError()) {
            $responseData = $result->getData();
        } else {
            \assert($result->getData() instanceof IncreaseCountryStatisticsCommand);

            $responseData = $this->userCase->handle($result->getData());
        }

        return $this->responder->createResponse($responseData);
    }
}
