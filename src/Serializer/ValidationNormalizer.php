<?php

declare(strict_types=1);

namespace App\Serializer;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolation;

final class ValidationNormalizer implements NormalizerInterface
{

    public function normalize($object, $format = null, array $context = array()): array
    {
        [$messages, $violations] = $this->getMessagesAndViolations($object);

        return [
            'title' => $context['title'] ?? 'An error occurred',
            'detail' => $messages ? implode("\n", $messages) : '',
            'violations' => $violations,
        ];
    }

    private function getMessagesAndViolations(FormErrorIterator $formErrors): array
    {
        $violations = $messages = [];

        /** @var FormError $error */
        foreach ($formErrors as $error) {
            /** @var ConstraintViolation $cause */
            $violation = $error->getCause();

            $violations[] = [
                'propertyPath' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
                'code' => $violation->getCode(),
            ];

            $propertyPath = $violation->getPropertyPath();
            $messages[] = ($propertyPath ? $propertyPath . ': ' : '') . $violation->getMessage();
        }
        return [$messages, $violations];
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof FormErrorIterator;
    }
}