<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;

class BadRequestHttpException extends \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
{
    public function __construct(Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct('Your data that you sent is not valid.', $previous, $code, $headers);
    }
}