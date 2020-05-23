<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Adapter;

use Cake\Collection\Collection;
use Rmr\Infrastructure\Exception\InvalidEntityException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValidatorAdapter
 * @package Rmr\Infrastructure\Adapter
 */
class ValidatorAdapter
{
    private ValidatorInterface $validator;

    /**
     * @param object $entity
     * @throws InvalidEntityException
     */
    public function validate(object $entity): void
    {
        $errors = $this->validator->validate($entity);

        if (count($errors) > 0) {
            $errors = (new Collection($errors))->map(static function (ConstraintViolationInterface $violation) {
                return [
                    'property' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage()
                ];
            });

            throw new InvalidEntityException($errors->toList());
        }
    }

    /**
     * @param string $constraint
     * @return ValidatorAdapter
     */
    public function setup(string $constraint): self
    {
        $constraintPath = dirname(__DIR__, 3) . "/config/validator/{$constraint}.yaml";

        $this->validator = Validation::createValidatorBuilder()
            ->addYamlMapping($constraintPath)
            ->getValidator();

        return $this;
    }
}
