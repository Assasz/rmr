<?php

namespace Rmr\Operation;

use Rmr\Adapter\SerializerAdapter;
use Rmr\Adapter\ValidatorAdapter;
use Rmr\Exception\InvalidEntityException;
use Rmr\Http\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trait ControllerTrait
 * @package Rmr\Operation
 */
trait ControllerTrait
{
    /** @var SerializerAdapter */
    protected $serializer;

    /** @var ValidatorAdapter */
    protected $validator;

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
     * Returns deserialized request body in form of given entity
     *
     * @param Request $request
     * @param string $entityClass
     * @param string|null $definition
     * @param array $context
     * @return object
     */
    protected function deserializeBody(Request $request, string $entityClass, string $definition = null, array $context = []): object
    {
        return $this->serializer->setup($definition)->deserialize($request->getContent(), $entityClass, $context);
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

    /**
     * Returns JSON representation of the resource
     *
     * @param object|array $resource
     * @param string|null $definition
     * @param array $context
     * @return string
     */
    protected function jsonRepresentation($resource, string $definition = null, array $context = []): string
    {
        return $this->serializer->setup($definition)->serialize($resource, $context);
    }
}
