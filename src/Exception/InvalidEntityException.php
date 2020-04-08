<?php

namespace Rmr\Exception;

use Throwable;

/**
 * Class InvalidEntityException
 * @package Rmr\Exception
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
