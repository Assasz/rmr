<?php

namespace Rmr\Operation;

use Rmr\Adapter\SerializerAdapter;
use Rmr\Resource\AbstractResource;
use Symfony\Component\HttpFoundation\Request;
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
     * Returns deserialized request body in form of given entity
     *
     * @param Request $request
     * @param string $entityClass
     * @param string|null $definition
     * @param array $context
     * @return object
     */
    protected function deserializeBody(Request $request, string $entityClass, string $definition = null, array $context = []): object
    {
        return $this->serializer->setup($definition)->deserialize($request->getContent(), $entityClass, $context);
    }

    /**
     * Returns array representation of the resource
     *
     * @param object|array $resource
     * @param string|null $definition
     * @param array $context
     * @return array
     */
    protected function arrayRepresentation($resource, string $definition = null, array $context = []): array
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
