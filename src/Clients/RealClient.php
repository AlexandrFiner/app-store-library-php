<?php

namespace AppStoreLibrary\Clients;

use AppStoreLibrary\Enums\AppStoreApi;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RealClient implements Client
{
    private const JWT_AUDIENCE = 'appstoreconnect-v1';
    private const JWT_HASH_ALG = 'ES256';
    private const JWT_EXPIRY_TIME_SECONDS = Carbon::SECONDS_PER_MINUTE * 5;
    public const REFRESH_INTERVAL_SECONDS = 30;

    protected \GuzzleHttp\Client $guzzle;
    #[ArrayShape(['token' => 'string|null', 'expires_at' => Carbon::class])]
    protected array $accessToken = ['token' => '', 'expires_at' => null];

    /**
     * @throws \Exception
     */
    public function __construct(
        private readonly AppStoreApi $appStoreAPI,
        private readonly Environment $environment,
        private array $credentials = []
    ) {
        $guzzleParams = [
            'http_errors' => false,
            'base_uri' => $this->getHost(),
        ];
        $this->guzzle = new \GuzzleHttp\Client($guzzleParams);
    }

    /**
     * @throws \Exception
     */
    public function getHost(): string
    {
        return $this->appStoreAPI->getHost($this->environment);
    }

    public function getMode(): string
    {
        return 'Real';
    }

    #[ArrayShape(['token' => 'string', 'expires_at' => Carbon::class])]
    public function getAccessToken(): array
    {
        $fetcher = function () {
            $expiresAt = Carbon::now()->addSeconds(self::JWT_EXPIRY_TIME_SECONDS);
            $token = JWT::encode(
                payload: [
                    'iss' => $this->credentials['APPSTORE_CONNECT_ISSUER_ID'] ?? '',
                    'exp' => $expiresAt->timestamp,
                    'aud' => self::JWT_AUDIENCE,
                    'bid' => $this->credentials['APPSTORE_CONNECT_BUNDLE_ID'] ?? '',
                ],
                key: $this->credentials['APPSTORE_CONNECT_PRIVATE_KEY'] ?? '',
                alg: self::JWT_HASH_ALG,
                head: [
                    'kid' => $this->credentials['APPSTORE_CONNECT_KEY_ID'] ?? '',
                ],
            );
            return ['token' => $token, 'expires_at' => $expiresAt];
        };

        if ($this->accessToken['expires_at']?->diffInSeconds(Carbon::now()) < self::REFRESH_INTERVAL_SECONDS) {
            $this->accessToken = $fetcher();
        }

        return $this->accessToken;
    }

    /**
     * @throws GuzzleException
     */
    public function request(RequestInterface $request, array $options = []): ResponseInterface
    {
        $accessToken = $this->getAccessToken()['token'];
        if ($accessToken) {
            $options['headers']['Authorization'] = "Bearer $accessToken";
        }
        return $this->guzzle->send($request, $options);
    }
}
