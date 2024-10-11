<?php

namespace AppStoreLibrary\AppStoreObjects;

use AppStoreLibrary\Helpers\JWT;

/**
 * @method static fromArray(array $json_decode, mixed $payload = null)
 */
trait HasSignable
{
    /**
     * @throws \Exception
     */
    public static function fromJWS(string $payload): static
    {
        return static::fromArray(JWT::parse($payload), $payload);
    }
}
