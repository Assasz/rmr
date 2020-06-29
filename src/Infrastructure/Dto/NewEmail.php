<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

declare(strict_types=1);

namespace Rmr\Infrastructure\Dto;

/**
 * Class NewEmail
 * @package Rmr\Infrastructure\Dto
 *
 * @OA\Schema()
 */
final class NewEmail
{
    /**
     * @OA\Property(
     *     type="string",
     *     example="john@doe.com"
     * )
     */
    public string $email;
}
