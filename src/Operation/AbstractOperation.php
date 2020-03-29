<?php

namespace Rmr\Operation;

/**
 * Class AbstractOperation
 * @package Rmr\Operation
 */
abstract class AbstractOperation
{
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