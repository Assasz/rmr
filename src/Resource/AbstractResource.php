<?php

namespace Rmr\Resource;

use Rmr\Http\Exception\MethodNotAllowedHttpException;
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
     * @throws MethodNotAllowedHttpException if HTTP method does not match any available operation's method
     */
    public function getOperation(string $method, string $uri): ResourceOperationInterface
    {
        foreach ($this->getOperationsMatchingUri($uri) as $operation) {
            if ($method !== $operation->getMethod()) {
                continue;
            }

            return $operation->setResource($this);
        }

        throw new MethodNotAllowedHttpException();
    }

    /**
     * Return resource operations matching given URI
     *
     * @param string $uri
     * @return ResourceOperationInterface[]
     * @throws NotFoundHttpException if operation does not exist
     */
    private function getOperationsMatchingUri(string $uri): array
    {
        $uri = rtrim($uri, '/');
        $operationsMatchingUri = [];

        foreach ($this->operations as $operation) {
            $operationPath = rtrim($operation->getPath(), '/');

            if (1 === preg_match("#^{$this->getPath()}{$operationPath}$#", $uri, $matches)) {
                $this->id = $matches['id'] ?? null;
                $operationsMatchingUri[] = $operation;
            }
        }

        if (true === empty($operationsMatchingUri)) {
            throw new NotFoundHttpException();
        }

        return $operationsMatchingUri;
    }

    /**
     * Returns path of the resource
     *
     * @return string
     */
    abstract public function getPath(): string;
}
