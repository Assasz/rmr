<?php

namespace Rmr\Http\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotFoundHttpException
 * @package Rmr\Http\Exception
 */
class NotFoundHttpException extends HttpException
{
    /**
     * NotFoundHttpException constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = 'Not found.', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(Response::HTTP_NOT_FOUND, $message, $code, $previous);
    }
}