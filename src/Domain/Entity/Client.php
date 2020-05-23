<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Domain\Entity;

/**
 * Class Client
 * @package Rmr\Domain\Entity
 */
class Client
{
    private int $id;

    private string $firstname;

    private string $lastname;

    private string $email;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Client
     */
    public function setId(int $id): Client
    {
        $this->id = $id;

        return $this;
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

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Client
     */
    public function setEmail(string $email): Client
    {
        $this->email = $email;

        return $this;
    }
}
