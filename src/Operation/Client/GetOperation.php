<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Operation\Client;

use Rmr\Operation\AbstractOperation;
use Rmr\Resource\Client\ClientResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetClientOperation
 * @package Rmr\Operation\Client
 */
class GetOperation extends AbstractOperation
{
    /** @var ClientResource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::GET_METHOD;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request): string
    {
        return $this->jsonRepresentation($this->resource->retrieve(), 'Client', ['groups' => 'read']);
    }
}
