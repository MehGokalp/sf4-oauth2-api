<?php

declare(strict_types=1);

namespace App\Exception;

class ServiceUnavailableHttpException extends \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException
{
    public function __construct(
        \Throwable $previous = null,
        ?int $code = 0,
        array $headers = []
    ) {
        parent::__construct(
            null,
            'Service is currently unavailable please try again later.',
            $previous,
            $code,
            $headers
        );
    }
}