<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NotChangedHttpException extends HttpException
{
    public function __construct(Exception $previous = null, $code = 0)
    {
        parent::__construct(304, 'Entity has not changed', $previous, [], $code);
    }
}
