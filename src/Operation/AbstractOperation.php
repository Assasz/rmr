<?php

namespace Rmr\Operation;

/**
 * Class AbstractOperation
 * @package Rmr\Operation
 */
abstract class AbstractOperation
{
    public const GET_METHOD = 'GET';
    public const POST_METHOD = 'POST';
    public const PUT_METHOD = 'PUT';
    public const PATCH_METHOD = 'PATCH';
    public const DELETE_METHOD = 'DELETE';

    /** @var array */
    protected $request;

    /** @var mixed */
    protected $resource;

    /**
     * AbstractOperation constructor.
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->request = $request;
    }

    /**
     * @param mixed $resource
     */
    public function setResource($resource): void
    {
        $this->resource = $resource;
    }
}
