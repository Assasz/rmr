<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Resource;

use Cake\Collection\Collection;
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
    public $id;

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
        $operations = $this->getOperationsMatchingUri($uri)->filter(
            static function (ResourceOperationInterface $operation) use ($method) {
                return $method === $operation->getMethod();
            }
        );

        if (true === $operations->isEmpty()) {
            throw new MethodNotAllowedHttpException();
        }

        return $operations->first()->setResource($this);
    }

    /**
     * Return resource operations matching given URI
     *
     * @param string $uri
     * @return Collection
     * @throws NotFoundHttpException if operation does not exist
     */
    private function getOperationsMatchingUri(string $uri): Collection
    {
        $self = $this;

        $operations = (new Collection($this->operations))->filter(
            static function (ResourceOperationInterface $operation) use ($uri, $self) {
                $operationPath = rtrim($operation->getPath(), '/');
                $uri = rtrim($uri, '/');

                if (true === $isMatch = (bool)preg_match("#^{$self->getPath()}{$operationPath}$#", $uri, $matches)) {
                    $self->id = $matches['id'] ?? null;
                }

                return $isMatch;
            }
        );

        if (true === $operations->isEmpty()) {
            throw new NotFoundHttpException();
        }

        return $operations;
    }

    /**
     * Returns path of the resource
     *
     * @return string
     */
    abstract public function getPath(): string;
}
