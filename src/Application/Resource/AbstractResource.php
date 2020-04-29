<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Application\Resource;

use Rmr\Ports\Operation\ResourceOperationInterface;

/**
 * Class AbstractResource
 * @package Rmr
 */
abstract class AbstractResource
{
    protected const NUMERIC_ID = '(?P<id>[0-9]+)';

    /** @var mixed */
    public $id;

    /** @var ResourceOperationInterface[] */
    protected $operations = [];

    /**
     * Returns path of the resource
     *
     * @return string
     */
    abstract public function getPath(): string;

    /**
     * Adds given operation to the resource
     *
     * @param ResourceOperationInterface $operation
     */
    public function addOperation(ResourceOperationInterface $operation): void
    {
        $this->operations[] = $operation;
    }

    /**
     * @return ResourceOperationInterface[]
     */
    public function getOperations(): array
    {
        return $this->operations;
    }
}
