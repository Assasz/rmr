<?php

namespace Rmr\Resource\Client;

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
    /** @var ClientRepositoryInterface */
    private $clientRepository;

    // TODO: we can inject another dependencies (as contracts!) via setters - traits are welcome

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
    public function retrieve()
    {
        // TODO: Implement retrieve() method.
    }

    /**
     * {@inheritdoc}
     */
    public function remove(): void
    {
        // TODO: Implement remove() method.
    }

    /**
     * {@inheritdoc}
     */
    public function replace($item): void
    {
        // TODO: Implement replace() method.
    }

    /**
     * {@inheritdoc}
     */
    public function insert($item): void
    {
        // TODO: Implement insert() method.
    }
}
