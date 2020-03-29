<?php

namespace Rmr\Resource;

use Rmr\Operation\ResourceOperationInterface;

/**
 * Class AbstractResource
 * @package Rmr
 */
abstract class AbstractResource
{
    public const GET_METHOD = 'GET';
    public const POST_METHOD = 'POST';
    public const PUT_METHOD = 'PUT';
    public const PATCH_METHOD = 'PATCH';
    public const DELETE_METHOD = 'DELETE';

    /** @var ResourceOperationInterface[] */
    protected $operations = [];

    /**
     * Adds given operation to the resource
     *
     * @param ResourceOperationInterface $operation
     */
    public function addOperation(ResourceOperationInterface $operation): void
    {
        $operation->setResource($this);
        $this->operations[] = $operation;
    }

    /**
     * Returns resource operation by given HTTP method and path
     *
     * @param string $method
     * @param string $path
     * @return ResourceOperationInterface
     * @throws \InvalidArgumentException if operation does not exist
     */
    public function getOperation(string $method, string $path): ResourceOperationInterface
    {
        foreach ($this->operations as $operation) {
            if ($method === $operation->getMethod() && $path === $this->getPath() . $operation->getPath()) {
                return $operation;
            }
        }

        throw new \InvalidArgumentException('Not found.');
    }

    /**
     * Returns path of the resource
     *
     * @return string
     */
    abstract public function getPath(): string;
}
