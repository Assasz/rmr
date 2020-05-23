<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Domain\Entity;

use Rmr\Domain\Exception\QuantityTooLowException;

/**
 * Class OrderProduct
 * @package Rmr\Domain\Entity
 */
class OrderProduct
{
    private int $id;

    private Order $order;

    private Product $product;

    private int $quantity;

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
     * @throws QuantityTooLowException
     */
    public function setQuantity(int $quantity): OrderProduct
    {
        if ($quantity < 1) {
            throw new QuantityTooLowException();
        }

        $this->quantity = $quantity;

        return $this;
    }
}
