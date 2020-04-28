<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Http\Formatter;

use Symfony\Component\HttpFoundation\Response;

/**
 * Interface FormatterInterface
 * @package Rmr\Infrastructure\Http\Formatter
 */
interface FormatterInterface
{
    /**
     * Returns formatted HTTP response
     *
     * @param mixed $content
     * @param int $statusCode
     * @return Response
     */
    public function format($content, int $statusCode): Response;
}
