<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Domain\Exception;

use Throwable;

/**
 * Class QuantityTooLowException
 * @package Rmr\Domain\Exception
 */
class QuantityTooLowException extends \InvalidArgumentException
{
    public const CODE = 1000;

    /**
     * QuantityTooLowException constructor.
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(string $message = 'Quantity too low.', Throwable $previous = null)
    {
        parent::__construct($message, self::CODE, $previous);
    }
}
