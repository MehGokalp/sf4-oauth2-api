<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Domain\ResponseInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class ResponseNormalizer implements ContextAwareNormalizerInterface
{
    /**
     * @param ResponseInterface $response
     * @return array
     */
    public function normalize($response, $format = null, array $context = [])
    {
        return $response->getData();
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof ResponseInterface;
    }
}
