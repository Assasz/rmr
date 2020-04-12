<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Http\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class UnprocessableEntityHttpException
 * @package Rmr\Http\Exception
 */
class UnprocessableEntityHttpException extends HttpException
{
    /**
     * UnprocessableEntityHttpException constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = 'Unprocessable entity.', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(Response::HTTP_UNPROCESSABLE_ENTITY, $message, $code, $previous);
    }
}
