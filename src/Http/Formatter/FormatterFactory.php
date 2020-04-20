<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Http\Formatter;

use Rmr\Http\Exception\NotAcceptableHttpException;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class FormatterFactory
 * @package Rmr\Http\Formatter
 */
class FormatterFactory
{
    /**
     * Creates formatter for first acceptable format
     *
     * @param string[] $acceptableFormats
     * @param FileLocatorInterface $fileLocator
     * @return FormatterInterface
     * @throws NotAcceptableHttpException if proper formatter does not exist
     */
    public static function create(array $acceptableFormats, FileLocatorInterface $fileLocator): FormatterInterface
    {
        $formatters = Yaml::parseFile($fileLocator->locate('formatters.yaml'))['formatters'];

        foreach ($acceptableFormats as $format) {
            if (true === array_key_exists($format, $formatters)) {
                return new $formatters[$format];
            }
        }

        throw new NotAcceptableHttpException(
            sprintf('Not acceptable. Please, use one of supported media types: %s.', implode(', ', array_keys($formatters)))
        );
    }
}
