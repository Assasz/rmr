<?php

declare(strict_types=1);

namespace Rmr\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class ApiTestCase extends TestCase
{
    use ApiAssertionsTrait;

    protected HttpClientInterface $client;

    public function setUp(): void
    {
        if (false === array_key_exists('BASE_URI', $_ENV)) {
            throw new \RuntimeException('BASE_URI variable needs to be defined in your .env.test file.');
        }

        $this->client = HttpClient::createForBaseUri($_ENV['BASE_URI'], ['HTTP_ACCEPT' => 'application/json']);
    }

//    protected function assertMatchesJsonSchema($data, string $schemaClassName): void
//    {
//        $data = json_decode($data);
//        $schemaReflection = new \ReflectionClass($schemaClassName);
//
//        $validator = new Validator();
//        $validator->validate($data, (object)['$ref' => "#/components/schemas/{$schemaReflection->getShortName()}"]);
//
//        if (false === $validator->isValid()) {
//            $errors = array_map(
//                static function (array $error): string {
//                    return "{$error['property']}: {$error['message']}";
//                },
//                $validator->getErrors()
//            );
//        }
//
//        $this->assertTrue(
//            $validator->isValid(),
//            sprintf('Provided data does not match JSON schema: %s.', implode(', ', $errors ?? []))
//        );
//    }
}
