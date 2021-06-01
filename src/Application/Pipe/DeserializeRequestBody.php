<?php

namespace App\Application\Pipe;

use App\Application\Error\ErrorFactory;
use App\Application\Result\PassableResult;
use App\Application\Result\ResultInterface;
use App\Infrastructure\Serialization\Symfony\RequestContext;
use App\Infrastructure\Serialization\Symfony\RequestSerializer;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class DeserializeRequestBody
{
    private RequestSerializer $requestSerializer;

    private ErrorFactory $errorFactory;

    public function __construct(RequestSerializer $requestSerializer, ErrorFactory $errorFactory)
    {
        $this->requestSerializer = $requestSerializer;
        $this->errorFactory      = $errorFactory;
    }

    public function handle($request, RequestContext $requestContext): ResultInterface
    {
        try {
            $body = $this->requestSerializer->deserializeRequestBody($request, $requestContext);

            $result = new PassableResult($body);
        } catch (ExceptionInterface $exception) {
            $result = $this->errorFactory->createInvalidRequestError($exception->getMessage());
        }

        return $result;
    }
}
