<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Http\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class MethodNotAllowedHttpException
 * @package Rmr\Http\Exception
 */
class MethodNotAllowedHttpException extends HttpException
{
    /**
     * MethodNotAllowedHttpException constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = 'Method not allowed.', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(Response::HTTP_METHOD_NOT_ALLOWED, $message, $code, $previous);
    }
}
