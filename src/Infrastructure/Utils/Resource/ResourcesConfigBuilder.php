<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Utils\Resource;

use Symfony\Component\Yaml\Yaml;

/**
 * Class ResourcesConfigBuilder
 * @package Rmr\Infrastructure\Utils\Resource
 */
final class ResourcesConfigBuilder
{
    private array $configuration;
    private ?string $selectedResource;

    public function __construct()
    {
        $this->load();
    }

    /**
     * Loads resources configuration
     *
     * @return $this
     */
    public function load(): self
    {
        $this->configuration = Yaml::parse(file_get_contents($this->getConfigFilePath()));

        return $this;
    }

    /**
     * Returns TRUE if resource record exists
     *
     * @param string $resource
     * @return bool
     */
    public function hasResource(string $resource): bool
    {
        return true === array_key_exists($resource, $this->configuration['resources']);
    }

    /**
     * Selects resource record - if it does not exist, new one is appended
     *
     * @param string $resource
     * @return $this
     */
    public function selectResource(string $resource): self
    {
        $this->selectedResource = (false === $this->hasResource($resource)) ?
            $this->appendResource($resource)->selectResource($resource) :
            $resource;

        return $this;
    }

    /**
     * Appends new resource record
     *
     * @param string $resource
     * @return $this
     */
    public function appendResource(string $resource): self
    {
        $this->configuration['resources'][$resource] = [];

        return $this;
    }

    /**
     * Merges provided operations with already registered to the resource
     *
     * @param string ...$operations
     * @return $this
     * @throws \BadMethodCallException
     */
    public function mergeOperations(string ...$operations): self
    {
        if (null === $this->selectedResource) {
            throw new \BadMethodCallException('There is no selected resource to merge operations into. See selectResource().');
        }

        $this->configuration['resources'][$this->selectedResource] = array_values(array_unique(array_merge(
            $operations,
            $this->configuration['resources'][$this->selectedResource]
        )));

        return $this;
    }

    /**
     * Saves configuration
     *
     * @return $this
     */
    public function save(): self
    {
        file_put_contents($this->getConfigFilePath(), Yaml::dump($this->configuration, 3, 2));

        return $this;
    }

    /**
     * @return string
     */
    public function getConfigFilePath(): string
    {
        return dirname(__DIR__, 4) . '/config/resources.yaml';
    }
}
