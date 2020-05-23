<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Http\Exception;

/**
 * Class HttpException
 * @package Rmr\Infrastructure\Http\Exception
 */
class HttpException extends \RuntimeException
{
    private int $statusCode;

    /**
     * HttpException constructor.
     * @param int $statusCode
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(int $statusCode, string $message = '', int $code = 0, \Throwable $previous = null)
    {
        $this->statusCode = $statusCode;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
