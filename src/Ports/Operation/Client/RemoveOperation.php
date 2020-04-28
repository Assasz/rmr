<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Ports\Operation\Client;

use Rmr\Ports\Operation\AbstractOperation;
use Rmr\Application\Resource\Client\ClientResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RemoveOperation
 * @package Rmr\Ports\Operation\Client
 */
class RemoveOperation extends AbstractOperation
{
    /** @var ClientResource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::DELETE_METHOD;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/';
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseStatus(): int
    {
        return Response::HTTP_NO_CONTENT;
    }

    /**
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $this->resource->remove();
    }
}
