<?php

declare(strict_types=1);

namespace Rmr\Tests\Functional;

use Rmr\Tests\Functional\Constraint\MatchesJsonSchema;
use Symfony\Contracts\HttpClient\ResponseInterface;

trait ApiAssertionsTrait
{
    public static function assertMatchesItemJsonSchema(ResponseInterface $response, string $schemaClassName, ?int $checkMode = null, string $message = ''): void
    {
        self::matchesJsonSchema($response->toArray(false), $schemaClassName, $checkMode, $message);
    }

    public static function assertMatchesCollectionJsonSchema(ResponseInterface $response, string $schemaClassName, ?int $checkMode = null, string $message = ''): void
    {
        self::matchesJsonSchema($response->toArray(false)[0], $schemaClassName, $checkMode, $message);
    }

    private static function matchesJsonSchema($data, string $schemaClassName, ?int $checkMode, string $message = ''): void
    {
        $constraint = new MatchesJsonSchema($schemaClassName, $checkMode);

        static::assertThat($data, $constraint, $message);
    }
}
