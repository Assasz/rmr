<?php

namespace Rmr\Http;

use Rmr\Http\Exception\NotFoundHttpException;
use Rmr\Operation\ResourceOperationInterface;
use Rmr\Resource\AbstractResource;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Router
 * @package Rmr\Http
 */
final class Router
{
    /** @var ContainerInterface */
    private $container;

    /**
     * Router constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @return callable
     */
    public function findResourceOperation(Request $request): callable
    {
        foreach ((new RouteMap())->get() as $resource => $operations) {
            try {
                /** @var callable $operation */
                $operation = $this->initializeResource($resource, $operations)->getOperation($request->getMethod(), $request->getUri());

                break;
            } catch (NotFoundHttpException $e) {
                continue;
            }
        }

        if (false === is_callable($operation ?? null)) {
            throw new NotFoundHttpException();
        }

        return $operation;
    }

    /**
     * @param string $resourceClass
     * @param array $operations
     * @return AbstractResource
     */
    private function initializeResource(string $resourceClass, array $operations): AbstractResource
    {
        /** @var AbstractResource $resource */
        $resource = $this->container->get($resourceClass);

        foreach ($operations as $operationClass) {
            /** @var ResourceOperationInterface $operation */
            $operation = $this->container->get($operationClass);
            $resource->addOperation($operation);
        }

        return $resource;
    }
}
