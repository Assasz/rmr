<?php

namespace Rmr\Operation;

use Rmr\Adapter\SerializerAdapter;
use Rmr\Resource\AbstractResource;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractOperation
 * @package Rmr\Operation
 */
abstract class AbstractOperation implements ResourceOperationInterface
{
    public const GET_METHOD = 'GET';
    public const POST_METHOD = 'POST';
    public const PUT_METHOD = 'PUT';
    public const PATCH_METHOD = 'PATCH';
    public const DELETE_METHOD = 'DELETE';

    /** @var AbstractResource */
    protected $resource;

    /** @var SerializerAdapter */
    protected $serializer;

    /**
     * @param $resource
     * @return AbstractOperation
     */
    public function setResource($resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * @required
     * @param SerializerAdapter $serializer
     */
    public function setSerializer(SerializerAdapter $serializer): void
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseStatus(): int
    {
        return Response::HTTP_OK;
    }

    /**
     * Returns array representation of the resource
     *
     * @param object|array $resource
     * @param string|null $definition
     * @param array $context
     * @return array
     */
    public function arrayRepresentation($resource, string $definition = null, array $context = []): array
    {
        $this->serializer->setup($definition);

        if (true === is_array($resource)) {
            foreach ($resource as $resourceItem) {
                $representation[] = $this->serializer->normalize($resourceItem, $context);
            }

            return $representation ?? [];
        }

        return $this->serializer->normalize($resource, $context);
    }
}
