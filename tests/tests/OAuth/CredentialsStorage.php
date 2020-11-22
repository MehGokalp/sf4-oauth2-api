<?php

declare(strict_types=1);

namespace App\Tests\OAuth;

use App\DataFixtures\ClientFixtures;
use App\DataFixtures\UserFixtures;

class CredentialsStorage
{
    // OAuth user login info
    protected string $oauthUserName;
    protected string $oauthUserPassword;

    // OAuth client login info
    protected string $oauthClientId;
    protected string $oauthClientSecret;

    public function __construct(
        string $oauthUserName = UserFixtures::DEFAULT_USER_USERNAME,
        string $oauthUserPassword = UserFixtures::DEFAULT_USER_PASS,
        string $oauthClientId = ClientFixtures::DEFAULT_IDENTIFIER,
        string $oauthClientSecret = ClientFixtures::DEFAULT_SECRET
    ) {
        $this->oauthUserName = $oauthUserName;
        $this->oauthUserPassword = $oauthUserPassword;
        $this->oauthClientId = $oauthClientId;
        $this->oauthClientSecret = $oauthClientSecret;
    }

    public function getCredentials(): array
    {
        return [
            'grant_type' => 'password',
            'scope' => '',
            'client_id' => $this->oauthClientId,
            'client_secret' => $this->oauthClientSecret,
            'username' => $this->oauthUserName,
            'password' => $this->oauthUserPassword
        ];
    }
}
