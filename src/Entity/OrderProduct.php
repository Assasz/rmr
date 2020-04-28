<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Entity;

/**
 * Class OrderProduct
 * @package Rmr\Entity
 */
class OrderProduct
{
    /** @var int */
    private $id;

    /** @var Order */
    private $order;

    /** @var Product */
    private $product;

    /** @var int */
    private $quantity;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrderProduct
     */
    public function setId(int $id): OrderProduct
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return OrderProduct
     */
    public function setOrder(Order $order): OrderProduct
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return OrderProduct
     */
    public function setProduct(Product $product): OrderProduct
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return OrderProduct
     */
    public function setQuantity(int $quantity): OrderProduct
    {
        $this->quantity = $quantity;

        return $this;
    }
}
