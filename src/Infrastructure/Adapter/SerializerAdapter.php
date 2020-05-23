<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Adapter;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\YamlFileLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class SerializerAdapter
 * @package Rmr\Infrastructure\Adapter
 */
class SerializerAdapter
{
    private SerializerInterface $serializer;

    /**
     * @param array|object $data
     * @param array $context
     * @return array
     */
    public function normalize($data, array $context = []): array
    {
        return $this->serializer->normalize($data, null, $context);
    }

    /**
     * @param string $data
     * @param string $outputClass
     * @param string $format
     * @param array $context
     * @return object
     */
    public function deserialize(string $data, string $outputClass, string $format, array $context = []): object
    {
        return $this->serializer->deserialize($data, $outputClass, $format, $context);
    }

    /**
     * @param string|null $definition
     * @return SerializerAdapter
     */
    public function setup(string $definition = null): self
    {
        if (false === empty($definition)) {
            $classMetadataFactory = new ClassMetadataFactory(new YamlFileLoader(
                dirname(__DIR__, 3) . "/config/serializer/{$definition}.yaml"
            ));
        }

        $this->serializer = new Serializer(
            [new DateTimeNormalizer(), new ObjectNormalizer($classMetadataFactory ?? null)],
            [new JsonEncoder(), new XmlEncoder()]
        );

        return $this;
    }
}
