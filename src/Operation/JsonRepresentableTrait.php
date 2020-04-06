<?php

namespace Rmr\Operation;

use Rmr\Adapter\SerializerAdapter;

/**
 * Trait JsonRepresentableTrait
 * @package Rmr\Operation
 */
trait JsonRepresentableTrait
{
    /**
     * Returns JSON representation of the resource
     *
     * @param object|array $resource
     * @param string|null $definition
     * @param array $context
     * @return string
     */
    protected function jsonRepresentation($resource, string $definition = null, array $context = []): string
    {
        /** @var SerializerAdapter $serializer */
        $serializer = $this->serializer;

        return $serializer->setup($definition)->serialize($resource, $context);
    }
}
