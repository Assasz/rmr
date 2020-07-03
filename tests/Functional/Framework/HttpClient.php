<?php

declare(strict_types=1);

namespace Rmr\Tests\Functional\Framework;

use Rmr\Infrastructure\Http\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HttpClient
{
    private const REQUEST_HEADERS = [
        'HTTP_ACCEPT' => 'application/json',
    ];

    private Kernel $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    public function request(string $method, string $uri, array $options = []): Response
    {
        return $this->kernel->handleRequest($this->prepareRequest($method, $uri, $options));
    }

    /**
     * @throws \RuntimeException
     */
    private function prepareRequest(string $method, string $uri, array $options = []): Request
    {
        if (false === array_key_exists('BASE_URI', $_ENV)) {
            throw new \RuntimeException('BASE_URI variable needs to be defined in your .env.test file.');
        }

        return Request::create(
            $_ENV['BASE_URI'] . $uri,
            $method,
            $options['parameters'] ?? [],
            $options['cookies'] ?? [],
            $options['files'] ?? [],
            array_merge(self::REQUEST_HEADERS, $options['server'] ?? []),
            (array_key_exists('json', $options)) ? json_encode($options['json']) : null
        );
    }
}
