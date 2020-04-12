<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Http;

use Rmr\Http\Exception\HttpException;
use Rmr\Operation\ResourceOperationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Run;

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

        $this->initializeErrorHandler();
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
            $operation = $this->router->findResourceOperation($request);
            $output = $operation($request);
        } catch (HttpException $e) {
            return $this->prepareJsonResponse(['error' => $e->getMessage()], $e->getStatusCode());
        } catch (\Throwable $e) {
            if ('prod' === $this->env) {
                return $this->prepareJsonResponse(['error' => 'Internal server error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            throw $e;
        }

        /** @var ResourceOperationInterface $operation */
        return $this->prepareJsonResponse($output, $operation->getResponseStatus());
    }

    /**
     * Initializes error handler for non-production environment
     */
    private function initializeErrorHandler(): void
    {
        if ('prod' === $this->env) {
            return;
        }

        (new Run)->pushHandler(new JsonResponseHandler())->register();
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

    /**
     * Returns JSON response ready to be sent to the client
     * For now it's JSON API, but it can be easily switched/extended with other formats
     *
     * @param mixed $content
     * @param int $statusCode
     * @return JsonResponse
     */
    private function prepareJsonResponse($content, int $statusCode): JsonResponse
    {
        if (true === is_scalar($content)) {
            return (new JsonResponse(null, $statusCode))->setJson($content);
        }

        return new JsonResponse($content, $statusCode);
    }
}
