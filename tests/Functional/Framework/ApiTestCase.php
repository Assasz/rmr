<?php

declare(strict_types=1);

namespace Rmr\Tests\Functional\Framework;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class ApiTestCase extends TestCase
{
    use ApiAssertionsTrait;

    protected HttpClientInterface $client;

    private const REQUEST_HEADERS = [
        'Accept' => 'application/json',
    ];

    public function setUp(): void
    {
        if (false === array_key_exists('BASE_URI', $_ENV)) {
            throw new \RuntimeException('BASE_URI variable needs to be defined in your .env.test file.');
        }

        $this->client = HttpClient::createForBaseUri($_ENV['BASE_URI'], ['headers' => self::REQUEST_HEADERS]);
    }
}
