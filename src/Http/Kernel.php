<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Http;

use Rmr\Http\Exception\HttpException;
use Rmr\Http\Exception\NotAcceptableHttpException;
use Rmr\Http\Formatter\FormatterFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\FileLocatorInterface;
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

        $this->container = $this->initializeContainer();
        $this->router = $this->initializeRouter();

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
     * @return FileLocatorInterface
     */
    public function getConfigLocator(): FileLocatorInterface
    {
        return new FileLocator(dirname(__DIR__, 2) . '/config');
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
            $formatter = FormatterFactory::create($request->getAcceptableContentTypes(), $this->getConfigLocator());
            $operation = $this->router->findResourceOperation($request);
            $output = $operation($request);
        } catch (NotAcceptableHttpException $e) {
            return new Response($e->getMessage(), $e->getStatusCode());
        } catch (HttpException $e) {
            return $formatter->format(['error' => $e->getMessage()], $e->getStatusCode());
        } catch (\Throwable $e) {
            if ('prod' === $this->env) {
                return $formatter->format(['error' => 'Internal server error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            throw $e;
        }

        return $formatter->format($output, $operation->getResponseStatus());
    }

    /**
     * Initializes DI container
     *
     * @throws \Exception
     * @return ContainerInterface
     */
    private function initializeContainer(): ContainerInterface
    {
        $container = new ContainerBuilder();

        $loader = new YamlFileLoader($container, $this->getConfigLocator());
        $loader->load('services.yaml');

        $container->compile();

        return $container;
    }

    /**
     * Initializes HTTP router
     *
     * @return Router
     */
    private function initializeRouter(): Router
    {
        return new Router(
            new ResourceLoader($this->container, $this->getConfigLocator())
        );
    }
}
