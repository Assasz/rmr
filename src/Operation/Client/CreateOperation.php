<?php

namespace Rmr\Operation\Client;

use Rmr\Entity\Client;
use Rmr\Http\Exception\BadRequestHttpException;
use Rmr\Operation\AbstractOperation;
use Rmr\Resource\Client\ClientCollectionResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreateClientOperation
 * @package Rmr
 */
class CreateOperation extends AbstractOperation
{
    /** @var ClientCollectionResource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::POST_METHOD;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/';
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseStatus(): int
    {
        return Response::HTTP_CREATED;
    }

    /**
     * @param Request $request
     * @return array
     * @throws BadRequestHttpException
     */
    public function __invoke(Request $request): array
    {
        // TODO: denormalization
        $requestBody = json_decode($request->getContent(), true) ?? [];

        if (array_diff_key(array_flip(['firstname', 'lastname', 'email']), $requestBody)) {
            throw new BadRequestHttpException();
        }

        $client = (new Client())
            ->setFirstname($requestBody['firstname'])
            ->setLastname($requestBody['lastname'])
            ->setEmail($requestBody['email']);

        $this->resource->insert($client);

        return ['client' => (string)$client];
    }
}
