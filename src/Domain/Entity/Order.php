<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Order
 * @package Rmr\Domain\Entity
 */
class Order
{
    /** @var int */
    private $id;

    /** @var \DateTimeInterface */
    private $dateCreated;

    /** @var Collection|OrderProduct[] */
    private $orderProducts;

    /**
     * Order constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->orderProducts = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Order
     */
    public function setId(int $id): Order
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateCreated(): \DateTimeInterface
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTimeInterface $dateCreated
     * @return Order
     */
    public function setDateCreated(\DateTimeInterface $dateCreated): Order
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * @return Collection|OrderProduct[]
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }
}
