<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Adapter;

use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
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
                dirname(__DIR__, 2) . "/config/serializer/{$definition}.yaml"
            ));
        }

        $this->serializer = new Serializer([new ObjectNormalizer($classMetadataFactory ?? null)], $this->getEncoders());

        return $this;
    }

    /**
     * @return EncoderInterface[]
     */
    private function getEncoders(): array
    {
        return [new JsonEncoder(), new XmlEncoder()];
    }
}
