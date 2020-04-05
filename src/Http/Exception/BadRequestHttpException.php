<?php

namespace Rmr\Http\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class BadRequestHttpException
 * @package Rmr\Http\Exception
 */
class BadRequestHttpException extends HttpException
{
    /**
     * BadRequestHttpException constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = 'Bad request.', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(Response::HTTP_BAD_REQUEST, $message, $code, $previous);
    }
}