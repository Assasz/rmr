<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Ports\Operation;

use Rmr\Application\Resource\AbstractResource;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractOperation
 * @package Rmr\Ports\Operation
 */
abstract class AbstractOperation implements ResourceOperationInterface
{
    use ControllerTrait;

    public const GET_METHOD = 'GET';
    public const POST_METHOD = 'POST';
    public const PUT_METHOD = 'PUT';
    public const PATCH_METHOD = 'PATCH';
    public const DELETE_METHOD = 'DELETE';

    /** @var AbstractResource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function setResource($resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseStatus(): int
    {
        return Response::HTTP_OK;
    }
}
