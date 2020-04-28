<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Domain\Entity;

use Money\Money;

/**
 * Class Product
 * @package Rmr\Domain\Entity
 */
class Product
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $priceTotal;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): Product
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getPriceTotal(): string
    {
        return $this->priceTotal;
    }

    /**
     * @param Money $priceTotal
     * @return Product
     */
    public function setPriceTotal(Money $priceTotal): Product
    {
        $this->priceTotal = $priceTotal->getAmount();

        return $this;
    }
}
