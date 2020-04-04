<?php

namespace Rmr\Http;

use Rmr\Http\Exception\HttpException;
use Rmr\Representation\JsonRepresentationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @return Kernel
     * @throws \Exception
     */
    public function boot(): self
    {
        $this->container = new ContainerBuilder();

        $configPath = dirname(__DIR__, 2) . '/config';
        $loader = new YamlFileLoader($this->container, new FileLocator($configPath));
        $loader->load('services.yaml');

        $this->container->compile();
        $this->router = new Router($this->container);

        return $this;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \RuntimeException
     */
    public function handleRequest(Request $request): JsonResponse
    {
        // TODO: add Whoops error handler
        try {
            $output = ($this->router->findResourceOperation($request))($request);
        } catch (HttpException $e) {
            return new JsonResponse(['error' => $e->getMessage()], $e->getStatusCode());
        }

        if (!$output instanceof JsonRepresentationInterface) {
            throw new \RuntimeException('Other formats are not supported at this moment!');
        }

        // TODO: add support for other formats!
        return (new JsonResponse())->setJson($output->toJson());
    }
}
