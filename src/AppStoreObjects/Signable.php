<?php

namespace AppStoreLibrary\AppStoreObjects;

interface Signable
{
    public static function fromJWS(string $payload): static;
}
