<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Http;

use Rmr\Http\Exception\NotFoundHttpException;
use Rmr\Operation\ResourceOperationInterface;
use Rmr\Resource\AbstractResource;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Router
 * @package Rmr\Http
 */
class Router
{
    /** @var ContainerInterface */
    private $container;

    /** @var array */
    private $resourceMap;

    /**
     * Router constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->resourceMap = Yaml::parseFile(dirname(__DIR__, 2) . '/config/resources.yaml')['resources'];
    }

    /**
     * Finds resource operation able to process given request
     *
     * @param Request $request
     * @return callable
     * @throws NotFoundHttpException if there is no proper operation mapped to any resource
     */
    public function findResourceOperation(Request $request): callable
    {
        foreach ($this->resourceMap as $resource => $operations) {
            try {
                /** @var callable $operation */
                $operation = $this->initializeResource($resource, $operations)->getOperation($request->getMethod(), $request->getPathInfo());

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
