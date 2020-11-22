<?php

declare(strict_types=1);

namespace App\Tests;

use App\Tests\OAuth\Handler;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractTestCase extends WebTestCase
{
    protected static KernelBrowser $client;

    protected static RouterInterface $router;

    // OAuth token
    protected static Handler $oauthHandler;

    public static function setUpBeforeClass()
    {
        self::$client = self::createClient();
        self::$router = self::$client->getContainer()->get('router');
        self::$oauthHandler = new Handler(self::$client, self::$router);
    }

    protected function request(
        string $method,
        string $uri,
        array $body = null,
        array $headers = [],
        bool $secure = true
    ): Response {
        $headers['CONTENT_TYPE'] = 'application/json';
        $headers['ACCEPT'] = 'application/json';

        if ($secure) {
            $tokenStorage = self::$oauthHandler->login();

            $headers['HTTP_Authorization'] = $tokenStorage->getHeader();
        }

        self::$client->request(
            $method,
            $uri,
            [],
            [],
            $headers,
            $body ? json_encode($body, JSON_THROW_ON_ERROR) : null
        );

        return self::$client->getResponse();
    }

    protected static function assertStatusCode(Response $response, int $statusCode): void
    {
        self::assertSame($statusCode, $response->getStatusCode(), $response->getContent());
    }

    protected function extractJsonContent(Response $response): array
    {
        return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }

    protected static function assertContentType(Response $response, string $contentType = 'application/json'): void
    {
        self::assertSame($response->headers->get('Content-Type'), $contentType);
    }

    protected function processJsonResponse(Response $response, int $statusCode): array
    {
        $this->assertStatusCode($response, $statusCode);
        $this->assertContentType($response);

        return $this->extractJsonContent($response);
    }
}
