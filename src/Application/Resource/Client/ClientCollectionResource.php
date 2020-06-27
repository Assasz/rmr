<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Application\Resource\Client;

use Cake\Collection\Collection;
use Rmr\Application\Contract\Adapter\EntityManagerAwareTrait;
use Rmr\Application\Contract\Repository\ClientRepositoryInterface;
use Rmr\Domain\Entity\Client;
use Rmr\Infrastructure\Http\Exception\UnprocessableEntityHttpException;
use Rmr\Application\Resource\AbstractResource;
use Rmr\Application\Resource\CollectionResourceInterface;

/**
 * Class ClientCollectionResource
 * @package Rmr
 */
class ClientCollectionResource extends AbstractResource implements CollectionResourceInterface
{
    use EntityManagerAwareTrait;

    private ClientRepositoryInterface $clientRepository;

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
        return ClientResource::PATH;
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
     * @throws UnprocessableEntityHttpException
     */
    public function insert($item): void
    {
        if (false === $this->supports($item)) {
            throw new UnprocessableEntityHttpException();
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
