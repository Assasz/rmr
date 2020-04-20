<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Http;

use Rmr\Operation\ResourceOperationInterface;
use Rmr\Resource\AbstractResource;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ResourceLoader
 * @package Rmr\Http
 */
class ResourceLoader
{
    /** @var array */
    private $resourceMap;

    /** @var ContainerInterface */
    private $container;

    /**
     * ResourceLoader constructor.
     * @param ContainerInterface $container
     * @param FileLocatorInterface $fileLocator
     */
    public function __construct(ContainerInterface $container, FileLocatorInterface $fileLocator)
    {
        $this->container = $container;
        $this->resourceMap = Yaml::parseFile($fileLocator->locate('resources.yaml'))['resources'];
    }

    /**
     * @return string[]
     */
    public function getResources(): array
    {
        return array_keys($this->resourceMap);
    }

    /**
     * Loads given resource class
     *
     * @param string $resourceClass
     * @return AbstractResource
     * @throws \RuntimeException
     */
    public function loadResource(string $resourceClass): AbstractResource
    {
        if (false === array_key_exists($resourceClass, $this->resourceMap)) {
            throw new \RuntimeException("Non existent resource {$resourceClass}.");
        }

        /** @var AbstractResource $resource */
        $resource = $this->container->get($resourceClass);

        foreach ($this->resourceMap[$resourceClass] as $operationClass) {
            /** @var ResourceOperationInterface $operation */
            $operation = $this->container->get($operationClass);
            $resource->addOperation($operation);
        }

        return $resource;
    }
}
