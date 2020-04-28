<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Http\Formatter;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonFormatter
 * @package Rmr\Infrastructure\Http\Formatter
 */
class JsonFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function format($content, int $statusCode): Response
    {
        return new JsonResponse($content, $statusCode);
    }
}
