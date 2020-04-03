<?php

namespace Rmr\Resource;

use Rmr\Http\Exception\NotFoundHttpException;
use Rmr\Operation\ResourceOperationInterface;

/**
 * Class AbstractResource
 * @package Rmr
 */
abstract class AbstractResource
{
    protected const NUMERIC_ID = '(?P<id>[0-9]+)';

    /** @var mixed */
    protected $id;

    /** @var ResourceOperationInterface[] */
    protected $operations = [];

    /**
     * Adds given operation to the resource
     *
     * @param ResourceOperationInterface $operation
     */
    public function addOperation(ResourceOperationInterface $operation): void
    {
        $this->operations[] = $operation;
    }

    /**
     * Returns resource operation by given HTTP method and URI
     *
     * @param string $method
     * @param string $uri
     * @return ResourceOperationInterface
     * @throws NotFoundHttpException if operation does not exist
     */
    public function getOperation(string $method, string $uri): ResourceOperationInterface
    {
        foreach ($this->operations as $operation) {
            $uriPattern = "#^{$this->getPath()}{$operation->getPath()}$#";

            if ($method === $operation->getMethod() && 1 === preg_match($uriPattern, $uri, $matches)) {
                $this->id = $matches['id'] ?? null;
                $operation->setResource($this);

                return $operation;
            }
        }

        throw new NotFoundHttpException();
    }

    /**
     * Returns path of the resource
     *
     * @return string
     */
    abstract public function getPath(): string;
}
