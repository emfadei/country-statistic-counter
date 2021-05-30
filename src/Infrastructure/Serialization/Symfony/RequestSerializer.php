<?php

namespace App\Infrastructure\Serialization\Symfony;

use App\Application\Query\Pagination;
use App\Application\Query\PaginationParametersInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RequestSerializer
{
    private const FORMATS_BY_CONTENT_TYPES = [
        'application/json' => 'json',
    ];

    private DenormalizerInterface $normalizer;

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer, DenormalizerInterface $normalizer)
    {
        $this->serializer = $serializer;
        $this->normalizer = $normalizer;
    }

    public function deserializeQueryParameters(Request $request, RequestContext $context): object
    {
        $parameters = $this->createParametersFromRequestQuery($request, $context->getNormalizationClass());

        if ($parameters instanceof PaginationParametersInterface) {
            [$page, $itemsPerPage] = $this->getPaginationParameters($request);
            $pagination            = new Pagination($page, $itemsPerPage);
            $parameters->setPagination($pagination);
        }

        $this->setRequestAttributesToDenormalizationData($request, $context, $parameters);

        return $parameters;
    }

    public function deserializeRequestBody(Request $request, RequestContext $context): object
    {
        $contentType = $request->headers->get('Content-Type');
        $contentType = explode(';', $contentType)[0];

        if (!\array_key_exists($contentType, self::FORMATS_BY_CONTENT_TYPES)) {
            throw new UnsupportedMediaTypeHttpException(sprintf('Unsupported media type: %s', $contentType));
        }

        $body = $this->serializer->deserialize(
            $request->getContent(),
            $context->getNormalizationClass(),
            self::FORMATS_BY_CONTENT_TYPES[$contentType],
            $context->getNormalizationContext()
        );

        $this->setRequestAttributesToDenormalizationData($request, $context, $body);

        return $body;
    }

    private function createParametersFromRequestQuery(Request $request, string $queryParametersClass): object
    {
        $parameters = $this->getParametersFromQuery($request->query);

        return $this->normalizer->denormalize(
            $parameters,
            $queryParametersClass,
            null,
            [
                AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true,
            ]
        );
    }

    private function setRequestAttributesToDenormalizationData(
        Request $request,
        RequestContext $context,
        object $denormalizationData
    ): void {
        $contextAttributes = $context->getAttributes();
        $attributes        = [];

        foreach ($contextAttributes as $attribute) {
            $attributes[$attribute] = $request->attributes->get($attribute);
        }

        $attributes = array_merge($attributes, $context->getCustomParameters());

        if (\count($attributes) > 0) {
            $this->normalizer->denormalize(
                $attributes,
                $context->getNormalizationClass(),
                null,
                [AbstractNormalizer::OBJECT_TO_POPULATE => $denormalizationData]
            );
        }
    }

    private function getParametersFromQuery(ParameterBag $query): array
    {
        $parameters = [];

        foreach ($query->all() as $name => $value) {
            if ('' !== $value) {
                $parameters[$name] = $value;
            }
        }

        return $parameters;
    }

    private function getPaginationParameters(Request $request): array
    {
        $page         = null === $request->query->get('page') ? Pagination::DEFAULT_PAGE : $request->query->getInt('page');
        $itemsPerPage = null === $request->query->get('itemsPerPage') ? Pagination::DEFAULT_ITEMS_PER_PAGE : $request->query->getInt('itemsPerPage');

        return [$page, $itemsPerPage];
    }
}
