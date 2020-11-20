<?php

namespace App\Exception;

use Throwable;

class NotFoundHttpException extends \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
{
    public function __construct(Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct('Entity not found', $previous, $code, $headers);
    }
}
