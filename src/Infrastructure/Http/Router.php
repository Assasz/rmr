<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Http;

use Cake\Collection\Collection;
use Rmr\Application\Resource\AbstractResource;
use Rmr\Infrastructure\Http\Exception\MethodNotAllowedHttpException;
use Rmr\Infrastructure\Http\Exception\NotFoundHttpException;
use Rmr\Ports\Operation\ResourceOperationInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Router
 * @package Rmr\Infrastructure\Http
 */
class Router
{
    /** @var ResourceLoader */
    private $resourceLoader;

    /**
     * Router constructor.
     * @param ResourceLoader $resourceLoader
     */
    public function __construct(ResourceLoader $resourceLoader)
    {
        $this->resourceLoader = $resourceLoader;
    }

    /**
     * Finds resource operation able to process given request
     *
     * @param Request $request
     * @return ResourceOperationInterface
     * @throws NotFoundHttpException if there is no proper operation mapped to any resource
     */
    public function findOperation(Request $request): ResourceOperationInterface
    {
        $operation = null;

        foreach ($this->resourceLoader->getResources() as $resourceClass) {
            try {
                $resource = $this->resourceLoader->loadResource($resourceClass);
                $operation = $this
                    ->filterOperationsByMethod(
                        $this->filterOperationsByUri($resource, $request->getPathInfo()),
                        $request->getMethod()
                    )
                    ->setResource($resource);

                break;
            } catch (NotFoundHttpException $e) {
                continue;
            }
        }

        if (!$operation instanceof ResourceOperationInterface) {
            throw new NotFoundHttpException();
        }

        return $operation;
    }

    /**
     * Returns resource operations matching given URI
     *
     * @param AbstractResource $resource
     * @param string $uri
     * @return Collection
     * @throws NotFoundHttpException if even one operation does not match URI pattern
     */
    private function filterOperationsByUri(AbstractResource $resource, string $uri): Collection
    {
        $operations = (new Collection($resource->getOperations()))->filter(
            static function (ResourceOperationInterface $operation) use ($uri, $resource) {
                $operationPath = rtrim($operation->getPath(), '/');
                $uri = rtrim($uri, '/');

                if (true === $isMatch = (bool)preg_match("#^{$resource->getPath()}{$operationPath}$#", $uri, $matches)) {
                    $resource->id = $matches['id'] ?? null;
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
     * Returns resource operation matching given HTTP method
     *
     * @param Collection $operations matching request URI
     * @param string $method
     * @return ResourceOperationInterface
     * @throws MethodNotAllowedHttpException if method does not match the method of any available operations
     */
    private function filterOperationsByMethod(Collection $operations, string $method): ResourceOperationInterface
    {
        $operations = $operations->filter(
            static function (ResourceOperationInterface $operation) use ($method) {
                return $method === $operation->getMethod();
            }
        );

        if (true === $operations->isEmpty()) {
            throw new MethodNotAllowedHttpException();
        }

        return $operations->first();
    }
}
