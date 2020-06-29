<?php

declare(strict_types=1);

namespace Rmr\Tests\Functional\Constraint;

use JsonSchema\Validator;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Class MatchesJsonSchema
 * @package Rmr\Tests\Functional\Constraint
 */
final class MatchesJsonSchema extends Constraint
{
    private object $schema;
    private ?int $checkMode;

    /**
     * MatchesJsonSchema constructor.
     * @param string $schemaClassName
     * @param int|null $checkMode
     */
    public function __construct(string $schemaClassName, ?int $checkMode = null)
    {
        $schemaReflection = new \ReflectionClass($schemaClassName);

        $this->schema = (object)['$ref' => "#/components/schemas/{$schemaReflection->getShortName()}"];
        $this->checkMode = $checkMode;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return 'matches the provided JSON Schema';
    }

    /**
     * {@inheritdoc}
     */
    protected function matches($other): bool
    {
        $other = $this->normalizeJson($other);

        $validator = new Validator();
        $validator->validate($other, $this->schema, $this->checkMode);

        return $validator->isValid();
    }

    /**
     * {@inheritdoc}
     */
    protected function additionalFailureDescription($other): string
    {
        $other = $this->normalizeJson($other);

        $validator = new Validator();
        $validator->validate($other, $this->schema, $this->checkMode);

        $errors = array_map(
            static function (array $error): string {
                return ($error['property'] ? $error['property'] . ': ' : '') . $error['message'];
            },
            $validator->getErrors()
        );

        return implode("\n", $errors);
    }

    /**
     * Normalizes a JSON document
     *
     * Specifically, we should ensure that:
     * 1. a JSON object is represented as a PHP object, not as an associative array
     */
    private function normalizeJson($document)
    {
        if (is_scalar($document) || \is_object($document)) {
            return $document;
        }

        if (!\is_array($document)) {
            throw new \InvalidArgumentException('Document must be scalar, array or object.');
        }

        $document = json_encode($document);

        if (!\is_string($document)) {
            throw new \UnexpectedValueException('JSON encode failed.');
        }

        $document = json_decode($document);

        if (!\is_array($document) && !\is_object($document)) {
            throw new \UnexpectedValueException('JSON decode failed.');
        }

        return $document;
    }
}
