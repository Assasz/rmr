<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Exception;

use Throwable;

/**
 * Class InvalidEntityException
 * @package Rmr\Infrastructure\Exception
 */
class InvalidEntityException extends \LogicException
{
    /** @var array */
    private $errors;

    /**
     * InvalidEntityException constructor.
     * @param array $errors
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(array $errors = [], $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
