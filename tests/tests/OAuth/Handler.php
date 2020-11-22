<?php

declare(strict_types=1);

namespace App\Tests\OAuth;

use App\Tests\OAuth\Exception\OAuthException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class Handler
{
    protected KernelBrowser $client;

    protected RouterInterface $router;

    public function __construct(KernelBrowser $client, RouterInterface $router)
    {
        $this->client = $client;
        $this->credentialsStorage = new CredentialsStorage();
        $this->router = $router;
    }

    protected CredentialsStorage $credentialsStorage;

    protected ?Token $tokenStorage = null;

    /**
     * @throws OAuthException
     */
    public function login(): Token
    {
        if ($this->tokenStorage && true === $this->tokenStorage->check()) {
            return $this->tokenStorage;
        }

        $this->client->request(
            Request::METHOD_POST,
            $this->router->generate('oauth2_token'),
            $this->credentialsStorage->getCredentials()
        );

        $response = $this->client->getResponse();

        if (Response::HTTP_OK !== $statusCode = $response->getStatusCode()) {
            throw new OAuthException(sprintf(
                'Error while fetching code: %s, response: %s',
                $statusCode,
                $response->getContent()
            ));
        }

        $body = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        return $this->tokenStorage = new Token(
            $body['token_type'],
            $body['expires_in'],
            $body['access_token'],
            $body['refresh_token']
        );
    }
}
