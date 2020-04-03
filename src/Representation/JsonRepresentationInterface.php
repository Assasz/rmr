<?php

namespace Rmr\Representation;

/**
 * Interface JsonRepresentationInterface
 * @package Rmr\Representation
 */
interface JsonRepresentationInterface
{
    /**
     * Returns JSON representation of the resource
     *
     * @return string
     */
    public function toJson(): string;
}
