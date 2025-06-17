<?php

namespace AppStoreLibrary\Clients;

use AppStoreLibrary\Enums\ServerApi\ErrorCodes;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class FakeClient implements Client
{
    private const JWT_EXPIRY_TIME_SECONDS = 10;
    public const REFRESH_INTERVAL_SECONDS = 5;
    public static ?string $responseBody = null;
    public static ?int $responseStatusCode = null;
    public static ?ErrorCodes $error = null;

    #[ArrayShape(['token' => 'string|null', 'expires_at' => Carbon::class])]
    protected array $accessToken = ['token' => '', 'expires_at' => null];

    public function getHost(): string
    {
        return 'localhost';
    }

    public function getMode(): string
    {
        return 'Test';
    }

    #[ArrayShape(['token' => 'string', 'expires_at' => Carbon::class])]
    public function getAccessToken(): array
    {
        if ($this->accessToken['expires_at']?->diffInSeconds(Carbon::now(), true) < self::REFRESH_INTERVAL_SECONDS) {
            $this->accessToken = [
                'token' => Str::uuid()->toString(),
                'expires_at' => Carbon::now()->addSeconds(self::JWT_EXPIRY_TIME_SECONDS),
            ];
        }

        return $this->accessToken;
    }

    public function request(RequestInterface $request, array $options = []): ResponseInterface
    {
        if (static::$error) {
            $response = json_encode(static::$error->toResponse());
            $statusCode = is_null(static::$responseStatusCode) ? 400 : static::$responseStatusCode;
        } else {
            $response = static::$responseBody;
            $statusCode = is_null(static::$responseStatusCode) ? 200 : static::$responseStatusCode;
            if (is_null($response)) {
                $uriWithoutBindings = preg_replace('/\/\d+/', '', $request->getUri()->__toString());
                $requestUri = str_replace(
                    search: '/',
                    replace: '_',
                    subject: trim($uriWithoutBindings, '/')
                );
                if ($cursor = $options['query']['cursor'] ?? null) {
                    $requestUri .= ".$cursor";
                }
                $response = file_get_contents(base_path("/tests/data/appstore.api.$requestUri.json"));
            }
        }

        if (!empty($options[RequestOptions::SINK])) {
            copy(static::$responseBody, $options[RequestOptions::SINK]);
        }

        static::$error = null;
        static::$responseBody = null;
        static::$responseStatusCode = null;

        return new Response(
            status: $statusCode,
            headers: [
                'Content-Type' => 'application/json',
                "X-Rate-Limit" => [
                    "user-hour-lim:3600;user-hour-rem:3599;",
                    "user-minute-lim:150;user-minute-rem:149;",
                ],
            ],
            body: $response,
        );
    }
}
