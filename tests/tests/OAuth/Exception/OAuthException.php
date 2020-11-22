<?php

declare(strict_types=1);

namespace App\Tests\OAuth\Exception;

use Exception;
use Throwable;

class OAuthException extends Exception
{
    public function __construct($message = 'OAuth exception occurred', Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
