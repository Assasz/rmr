<?php

namespace Rmr\Operation;

/**
 * Interface ResourceOperationInterface
 * @package Rmr
 */
interface ResourceOperationInterface
{
    /**
     * Returns HTTP method chosen to perform resource operation
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Returns operation path
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * @param $resource
     */
    public function setResource($resource);
}
