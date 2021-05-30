<?php

namespace App\Infrastructure\Serialization\Symfony\Normalizer;

use App\Application\Error\ErrorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class JsonErrorNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof ErrorInterface && 'json' === $format;
    }

    public function normalize($error, string $format = null, array $context = [])
    {
        \assert($error instanceof ErrorInterface);

        return [
            'message'    => $error->getMessage(),
            'violations' => [
                [
                    'code'    => $error->getCode(),
                    'message' => $error->getMessage(),
                ],
            ],
        ];
    }
}
