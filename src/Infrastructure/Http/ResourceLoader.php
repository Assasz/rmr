<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Http;

use Rmr\Operation\ResourceOperationInterface;
use Rmr\Application\Resource\AbstractResource;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ResourceLoader
 * @package Rmr\Infrastructure\Http
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
        $this->resourceMap = $this->parseResourceMap($fileLocator->locate('resources.yaml'));
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

    /**
     * @param string $file
     * @return array
     */
    private function parseResourceMap(string $file): array
    {
        return Yaml::parseFile($file)['resources'];
    }
}
