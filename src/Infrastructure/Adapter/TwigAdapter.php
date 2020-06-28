<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Adapter;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigAdapter
{
    private Environment $twig;

    public function __construct()
    {
        $this->setup();
    }

    /**
     * @param string $template
     * @param array $parameters
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(string $template, array $parameters): string
    {
        return $this->twig->render($template, $parameters);
    }

    private function setup(): void
    {
        $this->twig = new Environment(
            new FilesystemLoader(dirname(__DIR__, 3) . '/templates'),
            [
                'cache' => dirname(__DIR__, 3) . '/var/twig',
            ]
        );
    }
}
