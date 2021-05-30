<?php

namespace App\Application\Services;

use App\Application\Error\ErrorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class Responder
{
    private NormalizerInterface $normalizer;

    private ErrorCodeNegotiator $errorCodeNegotiator;

    private RequestStack $requestStack;

    public function __construct(NormalizerInterface $normalizer, ErrorCodeNegotiator $errorCodeNegotiator, RequestStack $requestStack)
    {
        $this->normalizer          = $normalizer;
        $this->errorCodeNegotiator = $errorCodeNegotiator;
        $this->requestStack        = $requestStack;
    }

    public function createResponse($data = null, ?int $statusCode = null, array $context = []): Response
    {
        $contentType = $this->getContentTypeFromRequest($context);

        $format  = 'application/json' === $contentType ? 'json' : null;
        $headers = ['Content-Type' => $contentType];

        switch (true) {
            case null === $data:
                $normalizedData = '';
                $httpCode       = $statusCode ?? Response::HTTP_NO_CONTENT;

                break;
            case $data instanceof ConstraintViolationListInterface:
                $httpCode       = Response::HTTP_BAD_REQUEST;
                $normalizedData = $this->normalizer->normalize($data, 'json');
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

    private function getContentTypeFromRequest(array $context): string
    {
        if (\array_key_exists('contentType', $context)) {
            return $context['contentType'];
        }

        $request = $this->requestStack->getCurrentRequest();
        \assert(null !== $request);

        $contentType = $request->headers->get('Content-Type');

        return empty($contentType) ? 'application/json' : $contentType;
    }
}
