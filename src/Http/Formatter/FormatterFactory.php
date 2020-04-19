<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Http\Formatter;

use Rmr\Http\Exception\NotAcceptableHttpException;

/**
 * Class FormatterFactory
 * @package Rmr\Http\Formatter
 */
class FormatterFactory
{
    /**
     * Creates formatter for first acceptable format
     *
     * @param array $acceptableFormats
     * @return FormatterInterface
     * @throws NotAcceptableHttpException if proper formatter does not exist
     */
    public static function create(array $acceptableFormats): FormatterInterface
    {
        foreach ($acceptableFormats as $format) {
            switch ($format) {
                case '*/*':
                    return new JsonFormatter();
                case 'application/*':
                    return new JsonFormatter();
                case 'application/json':
                    return new JsonFormatter();
                default:
                    continue 2;
            }
        }

        throw new NotAcceptableHttpException();
    }
}
