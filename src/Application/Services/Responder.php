<?php


namespace App\Application\Services;


use App\Application\Error\ErrorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class Responder
{
    private NormalizerInterface $normalizer;

    private ErrorCodeNegotiator $errorCodeNegotiator;

    public function __construct(NormalizerInterface $normalizer, ErrorCodeNegotiator $errorCodeNegotiator)
    {
        $this->normalizer          = $normalizer;
        $this->errorCodeNegotiator = $errorCodeNegotiator;
    }

    public function createResponse($data = null, ?int $statusCode = null, array $context = []): Response
    {
        $contentType = $context['contentType'] ?? 'application/json';

        $format  = 'application/json' === $contentType ? 'json' : null;
        $headers = ['Content-Type' => $contentType];

        switch (true) {
            case null === $data:
                $normalizedData = '';
                $httpCode       = $statusCode ?? Response::HTTP_NO_CONTENT;

                break;
            case $data instanceof ErrorInterface:
                $httpCode       = $this->errorCodeNegotiator->negotiateHttpCode($data);
                $normalizedData = $this->normalizer->normalize($data, $format, $context);

                break;
            default:
                $httpCode       = $statusCode ?? Response::HTTP_OK;
                $normalizedData = $this->normalizer->normalize($data, $format, $context);
        }

        return new JsonResponse($normalizedData, $httpCode, $headers);
    }
}