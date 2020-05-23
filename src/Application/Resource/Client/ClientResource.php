<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Application\Resource\Client;

use Rmr\Application\Contract\Adapter\EntityManagerAwareTrait;
use Rmr\Application\Contract\Repository\ClientRepositoryInterface;
use Rmr\Domain\Entity\Client;
use Rmr\Infrastructure\Http\Exception\NotFoundHttpException;
use Rmr\Infrastructure\Http\Exception\UnprocessableEntityHttpException;
use Rmr\Application\Resource\AbstractResource;
use Rmr\Application\Resource\ResourceInterface;

/**
 * Class ClientResource
 * @package Rmr
 */
class ClientResource extends AbstractResource implements ResourceInterface
{
    use EntityManagerAwareTrait;

    public const ROOT_PATH = '/clients/';

    private ClientRepositoryInterface $clientRepository;

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
         return self::ROOT_PATH . self::NUMERIC_ID;
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
