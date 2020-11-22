<?php

declare(strict_types=1);

namespace App\Tests\OAuth;

use DateTime;
use DateTimeInterface;

class Token
{
    protected string $tokenType;

    protected int $expiresIn;

    protected string $accessToken;

    protected string $refreshToken;

    /** @var DateTimeInterface */
    protected DateTimeInterface $expiresAt;

    public function __construct(
        string $tokenType,
        int $expiresIn,
        string $accessToken,
        string $refreshToken
    ) {
        $this->tokenType = $tokenType;
        $this->expiresIn = $expiresIn;
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->expiresAt = new DateTime(sprintf('+%d second', $expiresIn));
    }

    public function check(): bool
    {
        return !(new DateTime() > $this->expiresAt);
    }

    public function getHeader(): string
    {
        return sprintf('%s %s', $this->tokenType, $this->accessToken);
    }
}
