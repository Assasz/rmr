<?php

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
    private const ENCODERS = [JsonEncoder::class];

    /** @var Serializer */
    private $serializer;

    /**
     * @param object $entity
     * @param array $context
     * @return array
     */
    public function normalize(object $entity, array $context = []): array
    {
        return $this->serializer->normalize($entity, null, $context);
    }

    /**
     * @param string|null $definition
     * @return SerializerAdapter
     */
    public function setup(string $definition = null): self
    {
        foreach (self::ENCODERS as $ENCODER) {
            $encoders[] = new $ENCODER();
        }

        if (false === empty($definition)) {
            $classMetadataFactory = new ClassMetadataFactory(new YamlFileLoader(
                dirname(__DIR__, 2) . "/config/serializer/{$definition}.yaml"
            ));
        }

        $this->serializer = new Serializer([new ObjectNormalizer($classMetadataFactory ?? null)], $encoders ?? []);

        return $this;
    }
}
