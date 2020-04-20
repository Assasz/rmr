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
     * Enables debug mode for web environment (only for non-production)
     */
    public static function web(): void
    {
        if ('prod' === ($_ENV['APP_ENV'] ?? 'dev')) {
            error_reporting(0);
            ini_set('display_errors', 0);

            return;
        }

        (new Run())->pushHandler(new PrettyPageHandler())->register();
    }

    /**
     * Enables debug mode for CLI environment
     */
    public static function cli(): void
    {
        (new Run())->pushHandler(new PlainTextHandler())->register();
    }
}
