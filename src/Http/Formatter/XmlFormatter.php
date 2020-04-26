<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Http\Formatter;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

/**
 * Class XmlFormatter
 * @package Rmr\Http\Formatter
 */
class XmlFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function format($content, int $statusCode): Response
    {
        $xmlContent = (new XmlEncoder())->encode($content, 'xml');

        return new Response($xmlContent, $statusCode, ['Content-Type' => 'text/xml']);
    }
}
