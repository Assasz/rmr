<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Utils;

use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * Class Debug
 * @package Rmr\Utils
 */
class Debug
{
    /**
     * Enables debug mode for web environment
     */
    public static function web(): void
    {
        if ('prod' === ($_ENV['APP_ENV'] ?? 'dev')) {
            return;
        }

        (new Run())->pushHandler(new PrettyPageHandler())->register();
    }

    /**
     * Enables debug mode for CLI environment
     */
    public static function cli(): void
    {
        if ('prod' === ($_ENV['APP_ENV'] ?? 'dev')) {
            return;
        }

        (new Run())->pushHandler(new PlainTextHandler())->register();
    }
}
