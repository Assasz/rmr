<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Ports\Operation;

use Rmr\Infrastructure\Adapter\SerializerAdapter;
use Rmr\Infrastructure\Adapter\ValidatorAdapter;
use Rmr\Infrastructure\Exception\InvalidEntityException;
use Rmr\Infrastructure\Http\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trait ControllerTrait
 * @package Rmr\Ports\Operation
 */
trait ControllerTrait
{
    protected SerializerAdapter $serializer;

    protected ValidatorAdapter $validator;

    /**
     * @required
     * @param SerializerAdapter $serializer
     */
    public function setSerializer(SerializerAdapter $serializer): void
    {
        $this->serializer = $serializer;
    }

    /**
     * @required
     * @param ValidatorAdapter $validator
     */
    public function setValidator(ValidatorAdapter $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * Returns deserialized request body in form of entity object
     *
     * @param Request $request
     * @param string $entityClass
     * @param string|null $definition
     * @param array $context
     * @param string $format
     * @return object
     */
    protected function deserializeBody(Request $request, string $entityClass, string $definition = null, array $context = [], string $format = 'json'): object
    {
        return $this->serializer->setup($definition)->deserialize($request->getContent(), $entityClass, $format, $context);
    }

    /**
     * Returns normalized representation of the resource
     *
     * @param object|array $resource
     * @param string|null $definition
     * @param array $context
     * @return array
     */
    protected function normalizeResource($resource, string $definition = null, array $context = []): array
    {
        return $this->serializer->setup($definition)->normalize($resource, $context);
    }

    /**
     * Validates given entity object against specified constraint
     *
     * @param object $entity
     * @param string $constraint
     * @throws BadRequestHttpException
     */
    protected function validate(object $entity, string $constraint): void
    {
        try {
            $this->validator->setup($constraint)->validate($entity);
        } catch (InvalidEntityException $e) {
            throw new BadRequestHttpException($e->getErrors());
        }
    }
}
