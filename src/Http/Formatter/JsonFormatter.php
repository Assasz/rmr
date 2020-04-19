<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Http\Formatter;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonFormatter
 * @package Rmr\Http\Formatter
 */
class JsonFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function format($content, int $statusCode): Response
    {
        if (true === is_scalar($content)) {
            return (new JsonResponse(null, $statusCode))->setJson($content);
        }
        
        return new JsonResponse($content, $statusCode);
    }
}
