<?php

namespace Rmr\Operation\Client;

use Rmr\Http\Exception\BadRequestHttpException;
use Rmr\Operation\AbstractOperation;
use Rmr\Resource\Client\ClientResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UpdateEmailOperation
 * @package Rmr\Operation\Client
 */
class UpdateEmailOperation extends AbstractOperation
{
    /** @var ClientResource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::PATCH_METHOD;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/email';
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

        if (false === array_key_exists('email', $requestBody)) {
            throw new BadRequestHttpException();
        }

        $client = $this->resource->retrieve();

        $client->setEmail($requestBody['email']);
        $this->resource->save();

        return ['client' => (string)$client];
    }
}
