<?php

namespace AppStoreLibrary\Clients;

use Carbon\Carbon;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface Client
{
    public function getHost(): string;
    public function getMode(): string;
    #[ArrayShape(['token' => 'string', 'expires_at' => Carbon::class])]
    public function getAccessToken(): array;
    public function request(RequestInterface $request, array $options = []): ResponseInterface;
}
