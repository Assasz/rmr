<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Http\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotAcceptableHttpException
 * @package Rmr\Infrastructure\Http\Exception
 */
class NotAcceptableHttpException extends HttpException
{
    /**
     * NotAcceptableHttpException constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = 'Not acceptable.', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(Response::HTTP_NOT_ACCEPTABLE, $message, $code, $previous);
    }
}
