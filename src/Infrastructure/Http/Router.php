<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Http;

use Rmr\Infrastructure\Http\Exception\NotFoundHttpException;
use Rmr\Ports\Operation\ResourceOperationInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Router
 * @package Rmr\Infrastructure\Http
 */
class Router
{
    /** @var ResourceLoader */
    private $resourceLoader;

    /**
     * Router constructor.
     * @param ResourceLoader $resourceLoader
     */
    public function __construct(ResourceLoader $resourceLoader)
    {
        $this->resourceLoader = $resourceLoader;
    }

    /**
     * Finds resource operation able to process given request
     *
     * @param Request $request
     * @return ResourceOperationInterface
     * @throws NotFoundHttpException if there is no proper operation mapped to any resource
     */
    public function findResourceOperation(Request $request): ResourceOperationInterface
    {
        $operation = null;

        foreach ($this->resourceLoader->getResources() as $resource) {
            try {
                $operation = $this->resourceLoader
                    ->loadResource($resource)
                    ->getOperation($request->getMethod(), $request->getPathInfo());

                break;
            } catch (NotFoundHttpException $e) {
                continue;
            }
        }

        if (!$operation instanceof ResourceOperationInterface) {
            throw new NotFoundHttpException();
        }

        return $operation;
    }
}
