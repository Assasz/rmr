<?php

namespace Rmr\Resource\Client;

use Rmr\Contract\Repository\ClientRepositoryInterface;
use Rmr\Entity\Client;
use Rmr\Resource\AbstractResource;
use Rmr\Resource\ResourceInterface;

/**
 * Class ClientResource
 * @package Rmr
 */
class ClientResource extends AbstractResource implements ResourceInterface
{
    /** @var ClientRepositoryInterface */
    private $clientRepository;

    /**
     * ClientResource constructor.
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
         return '/clients/' . self::NUMERIC_ID;
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
        return $this->clientRepository->find($this->id);
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
}
