<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Http;

use Rmr\Http\Exception\HttpException;
use Rmr\Http\Exception\NotAcceptableHttpException;
use Rmr\Http\Formatter\FormatterFactory;
use Rmr\Operation\ResourceOperationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Kernel
 * @package Rmr\Http
 */
final class Kernel
{
    /** @var Router */
    private $router;

    /** @var ContainerInterface */
    private $container;

    /** @var string */
    private $env;

    /** @var bool */
    private $booted = false;

    /**
     * @param string $env
     * @return Kernel
     * @throws \Exception
     */
    public function boot(string $env = 'dev'): self
    {
        $this->env = $env;

        $this->initializeContainer();

        $this->router = new Router($this->container);
        $this->booted = true;

        return $this;
    }

    /**
     * @return Kernel
     */
    public function shutdown(): self
    {
        $this->container = $this->router = null;
        $this->booted = false;

        return $this;
    }

    /**
     * @return ContainerInterface
     * @throws \RuntimeException if kernel is not booted
     */
    public function getContainer(): ContainerInterface
    {
        if (false === $this->booted) {
            throw new \RuntimeException('Unable to obtain container when kernel is not booted. Please, boot kernel first.');
        }

        return $this->container;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \RuntimeException if kernel is not booted
     * @throws \Throwable
     */
    public function handleRequest(Request $request): Response
    {
        if (false === $this->booted) {
            throw new \RuntimeException('Unable to handle request when kernel is not booted. Please, boot kernel first.');
        }

        try {
            $formatter = FormatterFactory::create($request->getAcceptableContentTypes());
        } catch (NotAcceptableHttpException $e) {
            return new Response($e->getMessage(), $e->getStatusCode());
        }

        try {
            $operation = $this->router->findResourceOperation($request);
            $output = $operation($request);
        } catch (HttpException $e) {
            return $formatter->format(['error' => $e->getMessage()], $e->getStatusCode());
        } catch (\Throwable $e) {
            if ('prod' === $this->env) {
                return $formatter->format(['error' => 'Internal server error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            throw $e;
        }

        /** @var ResourceOperationInterface $operation */
        return $formatter->format($output, $operation->getResponseStatus());
    }

    /**
     * Initializes DI container
     *
     * @throws \Exception
     */
    private function initializeContainer(): void
    {
        $this->container = new ContainerBuilder();

        $loader = new YamlFileLoader($this->container, new FileLocator(dirname(__DIR__, 2) . '/config'));
        $loader->load('services.yaml');

        $this->container->compile();
    }
}
