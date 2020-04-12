<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Adapter;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\YamlFileLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class SerializerAdapter
 * @package Rmr\Adapter
 */
class SerializerAdapter
{
    /** @var Serializer */
    private $serializer;

    /**
     * @param object|array $data
     * @param array $context
     * @return string
     */
    public function serialize($data, array $context = []): string
    {
        return $this->serializer->serialize($data, 'json', $context);
    }

    /**
     * @param string $data
     * @param string $outputClass
     * @param array $context
     * @return object
     */
    public function deserialize(string $data, string $outputClass, array $context = []): object
    {
        return $this->serializer->deserialize($data, $outputClass, 'json', $context);
    }

    /**
     * @param string|null $definition
     * @return SerializerAdapter
     */
    public function setup(string $definition = null): self
    {
        if (false === empty($definition)) {
            $classMetadataFactory = new ClassMetadataFactory(new YamlFileLoader(
                dirname(__DIR__, 2) . "/config/serializer/{$definition}.yaml"
            ));
        }

        $this->serializer = new Serializer([new ObjectNormalizer($classMetadataFactory ?? null)], [new JsonEncoder()]);

        return $this;
    }
}
