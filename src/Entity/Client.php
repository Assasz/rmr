<?php

namespace Rmr\Entity;

/**
 * Class Client
 * @package Rmr\Entity
 */
class Client
{
    /** @var int */
    private $id;

    /** @var string */
    private $firstname;

    /** @var string */
    private $lastname;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return Client
     */
    public function setFirstname(string $firstname): Client
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return Client
     */
    public function setLastname(string $lastname): Client
    {
        $this->lastname = $lastname;

        return $this;
    }
}
