<?php

namespace Rmr\Resource\Client;

use Cake\Collection\Collection;
use Rmr\Contract\Adapter\EntityManagerAwareTrait;
use Rmr\Contract\Repository\ClientRepositoryInterface;
use Rmr\Entity\Client;
use Rmr\Resource\AbstractResource;
use Rmr\Resource\CollectionResourceInterface;

/**
 * Class ClientCollectionResource
 * @package Rmr
 */
class ClientCollectionResource extends AbstractResource implements CollectionResourceInterface
{
    use EntityManagerAwareTrait;

    /** @var ClientRepositoryInterface */
    private $clientRepository;

    // we can inject another dependencies (as contracts!) via setters - traits are welcome

    /**
     * ClientCollectionResource constructor.
     * @param ClientRepositoryInterface $clientRepository
     */
    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/clients';
    }

    /**
     * {@inheritdoc}
     */
    public function supports($item): bool
    {
        return $item instanceof Client;
    }

    /**
     * {@inheritdoc}
     */
    public function retrieve(): Collection
    {
        return new Collection($this->clientRepository->fetchAll());
    }

    // we don't want to remove or replace whole collection at once, usually

    /**
     * {@inheritdoc}
     */
    public function remove(): void
    {
        throw new \LogicException('Not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function replace($item): void
    {
        throw new \LogicException('Not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function insert($item): void
    {
        if (false === $this->supports($item)) {
            throw new \InvalidArgumentException('Unable to insert new client to the collection - invalid input provided.');
        }

        $this->entityManager->persist($item);
        $this->save();
    }

    /**
     * {@inheritdoc}
     */
    public function save(): void
    {
        $this->entityManager->flush();
    }
}
