<?php

namespace Rmr\Resource\Client;

use Rmr\Contract\Adapter\EntityManagerAwareTrait;
use Rmr\Contract\Repository\ClientRepositoryInterface;
use Rmr\Entity\Client;
use Rmr\Http\Exception\NotFoundHttpException;
use Rmr\Http\Exception\UnprocessableEntityHttpException;
use Rmr\Resource\AbstractResource;
use Rmr\Resource\ResourceInterface;

/**
 * Class ClientResource
 * @package Rmr
 */
class ClientResource extends AbstractResource implements ResourceInterface
{
    use EntityManagerAwareTrait;

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
     * @throws NotFoundHttpException
     */
    public function retrieve(): Client
    {
        $client = $this->clientRepository->pick($this->id);

        if (false === $this->supports($client)) {
            throw new NotFoundHttpException();
        }

        return $client;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(): void
    {
        $this->entityManager->remove($this->retrieve());
        $this->save();
    }

    /**
     * {@inheritdoc}
     * @throws UnprocessableEntityHttpException
     */
    public function replace($item): void
    {
        if (false === $this->supports($item)) {
            throw new UnprocessableEntityHttpException();
        }

        $this->entityManager->replace($item);
        $this->save();
    }

    /**
     * {@inheritdoc}
     */
    public function save(): void
    {
        $this->entityManager->flush();
    }

    /**
     * Updates client email
     *
     * @param string $email
     */
    public function updateEmail(string $email): void
    {
        $this->retrieve()->setEmail($email);
        $this->save();
    }
}
