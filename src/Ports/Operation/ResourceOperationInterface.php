<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Ports\Operation;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface ResourceOperationInterface
 * @package Rmr\Ports\Operation
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
     * Returns HTTP status code, which is assumed as successful for this particular operation
     *
     * @return int
     */
    public function getResponseStatus(): int;

    /**
     * @param mixed $resource
     */
    public function setResource($resource);

    /**
     * @param Request $request
     * @return mixed
     */
    public function __invoke(Request $request);
}
