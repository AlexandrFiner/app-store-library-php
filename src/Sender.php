<?php

namespace AppStoreLibrary;

use AppStoreLibrary\Clients\Client;
use AppStoreLibrary\Enums\AppStoreApi;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Exceptions\AppStoreServerApiException;
use AppStoreLibrary\Requests\ConsumptionRequest;
use AppStoreLibrary\Requests\DownloadFinanceReportsRequest;
use AppStoreLibrary\Requests\DownloadSalesAndTrendsReportsRequest;
use AppStoreLibrary\Requests\NotificationHistoryRequest;
use AppStoreLibrary\Requests\SubscriptionAppStoreReviewScreenshotCreateRequest;
use AppStoreLibrary\Requests\SubscriptionAppStoreReviewScreenshotUpdateRequest;
use AppStoreLibrary\Requests\SubscriptionAvailabilityCreateRequest;
use AppStoreLibrary\Requests\SubscriptionCreateRequest;
use AppStoreLibrary\Requests\SubscriptionLocalizationCreateRequest;
use AppStoreLibrary\Requests\SubscriptionUpdateRequest;
use AppStoreLibrary\Responses\ConnectApi\SubscriptionAppStoreReviewScreenshotResponse;
use AppStoreLibrary\Responses\ConnectApi\SubscriptionGroupsResponse;
use AppStoreLibrary\Responses\ConnectApi\SubscriptionLocalizationResponse;
use AppStoreLibrary\Responses\ConnectApi\SubscriptionPricePointEqualizationsLinkagesResponse;
use AppStoreLibrary\Responses\ConnectApi\SubscriptionPricePointsResponse;
use AppStoreLibrary\Responses\ConnectApi\SubscriptionPricesResponse;
use AppStoreLibrary\Responses\ConnectApi\SubscriptionResponse;
use AppStoreLibrary\Responses\ConnectApi\SubscriptionsByGroupResponse;
use AppStoreLibrary\Responses\ConnectApi\TerritoriesResponse;
use AppStoreLibrary\Responses\ServerApi\NotificationHistoryResponse;
use AppStoreLibrary\Responses\ServerApi\StatusResponse;
use AppStoreLibrary\Responses\ServerApi\TransactionInfoResponse;
use Carbon\Carbon;
use Closure;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Sender
{
    /** @var Client[] $clients */
    private array $clients;

    /**
     * @throws \Exception
     */
    public function __construct(string $client, Environment $environment, array $credentials)
    {
        if (!is_subclass_of($client, Client::class)) {
            throw new \InvalidArgumentException("Unknown AppStoreServer client: $client");
        }
        foreach (AppStoreApi::cases() as $api) {
            $this->clients[$api->value] = new $client($api, $environment, $credentials);
        }
    }

    public function getClient(AppStoreApi $api): Client
    {
        return $this->clients[$api->value];
    }

    private function request(
        AppStoreApi $api,
        string $method,
        string $uri,
        array $options = [],
        ?Closure $afterRequest = null,
    ): ResponseInterface {
        try {
            $startedAt = Carbon::now();
            $request = new Request($method, $uri);
            $response = $this->clients[$api->value]->request($request, $options);
            return $response;
        } catch (Throwable $e) {
            throw $e;
        } finally {
            if ($afterRequest) {
                $response?->getBody()->rewind();
                $afterRequest(
                    $startedAt ?? null,
                    $request ?? null,
                    $options ?? [],
                    $response ?? null,
                    $e ?? null
                );
            }
        }
    }

    /**
     * Get information about a single transaction for your app.
     * https://developer.apple.com/documentation/appstoreserverapi/get_transaction_info
     *
     * @param  string  $transactionId  The identifier of a transaction
     * @param  Closure|null  $afterRequest
     * @return TransactionInfoResponse
     * @throws AppStoreServerApiException
     */
    public function getTransactionInfo(string $transactionId, ?Closure $afterRequest = null): TransactionInfoResponse
    {
        return new TransactionInfoResponse(
            $this->request(
                api: AppStoreApi::AppStoreServer,
                method: 'GET',
                uri: "/inApps/v1/transactions/$transactionId",
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * Get a list of subscription groups for a specific app
     * @link https://developer.apple.com/documentation/appstoreconnectapi/list_all_subscription_groups_for_an_app
     *
     * @param  int  $appId
     * @param  int  $limit
     * @param  string|null  $cursor
     * @param  Closure|null  $afterRequest
     * @return SubscriptionGroupsResponse
     * @throws AppStoreServerApiException
     */
    public function getAppSubscriptionGroups(
        int $appId,
        int $limit = 200,
        ?string $cursor = null,
        ?Closure $afterRequest = null,
    ): SubscriptionGroupsResponse {
        if ($limit < 1 || $limit > 200) {
            throw new \OutOfRangeException('The limit must be between 1 and 200 included');
        }

        return new SubscriptionGroupsResponse(
            $this->request(
                api: AppStoreApi::AppStoreConnect,
                method: 'GET',
                uri: "/v1/apps/$appId/subscriptionGroups",
                options: [
                    RequestOptions::QUERY => [
                        'limit' => $limit,
                        'cursor' => $cursor,
                    ],
                ],
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * List All Subscriptions for a Subscription Group
     * @link https://developer.apple.com/documentation/appstoreconnectapi/list_all_subscriptions_for_a_subscription_group
     *
     * @param  int  $subscriptionGroupId
     * @param  int  $limit
     * @param  string|null  $cursor
     * @param  Closure|null  $afterRequest
     * @return SubscriptionsByGroupResponse
     * @throws AppStoreServerApiException
     */
    public function getSubscriptionsByGroup(
        int $subscriptionGroupId,
        int $limit = 200,
        ?string $cursor = null,
        ?Closure $afterRequest = null,
    ): SubscriptionsByGroupResponse {
        if ($limit < 1 || $limit > 200) {
            throw new \OutOfRangeException('The limit must be between 1 and 200 included');
        }

        return new SubscriptionsByGroupResponse(
            $this->request(
                api: AppStoreApi::AppStoreConnect,
                method: 'GET',
                uri: "/v1/subscriptionGroups/$subscriptionGroupId/subscriptions",
                options: [
                    RequestOptions::QUERY => [
                        'limit' => $limit,
                        'cursor' => $cursor,
                    ],
                ],
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * Get a list of prices for an auto-renewable subscription, by territory.
     * @link https://developer.apple.com/documentation/appstoreconnectapi/list_all_prices_for_a_subscription
     *
     * @param  int  $subscriptionId
     * @param  int  $limit
     * @param  string|null  $cursor
     * @param  Closure|null  $afterRequest
     * @return SubscriptionPricesResponse
     * @throws AppStoreServerApiException
     */
    public function getSubscriptionPrices(
        int $subscriptionId,
        int $limit = 200,
        ?string $cursor = null,
        ?Closure $afterRequest = null,
    ): SubscriptionPricesResponse {
        if ($limit < 1 || $limit > 200) {
            throw new \OutOfRangeException('The limit must be between 1 and 200 included');
        }

        return new SubscriptionPricesResponse(
            $this->request(
                api: AppStoreApi::AppStoreConnect,
                method: 'GET',
                uri: "/v1/subscriptions/$subscriptionId/prices",
                options: [
                    RequestOptions::QUERY => [
                        'fields[subscriptionPricePoints]' => 'customerPrice',
                        'fields[territories]' => 'currency',
                        'include' => 'subscriptionPricePoint,territory',
                        'limit' => $limit,
                        'cursor' => $cursor,
                    ],
                ],
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * Send consumption information about a consumable in-app purchase or auto-renewable
     * subscription to the App Store after your server receives a consumption request notification.
     * @link https://developer.apple.com/documentation/appstoreserverapi/send_consumption_information
     *
     * @param  string  $transactionId
     * @param  ConsumptionRequest  $consumptionRequest
     * @param  Closure|null  $afterRequest
     * @return void
     */
    public function sendConsumptionInformation(
        string $transactionId,
        ConsumptionRequest $consumptionRequest,
        ?Closure $afterRequest = null,
    ): void {
        $this->request(
            api: AppStoreApi::AppStoreServer,
            method: 'PUT',
            uri: "/inApps/v1/transactions/consumption/$transactionId",
            options: [
                RequestOptions::JSON => $consumptionRequest->toResponse(),
            ],
            afterRequest: $afterRequest,
        );
    }

    /**
     * Get a list of notifications that the App Store server attempted to send to your server.
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_notification_history
     *
     * @param  NotificationHistoryRequest  $request
     * @param  string  $paginationToken
     * @param  Closure|null  $afterRequest
     * @return NotificationHistoryResponse
     * @throws AppStoreServerApiException
     */
    public function getNotificationHistory(
        NotificationHistoryRequest $request,
        string $paginationToken = '',
        ?Closure $afterRequest = null,
    ): NotificationHistoryResponse {
        return new NotificationHistoryResponse(
            $this->request(
                api: AppStoreApi::AppStoreServer,
                method: 'POST',
                uri: '/inApps/v1/notifications/history/',
                options: [
                    RequestOptions::JSON => $request->toResponse(),
                    RequestOptions::QUERY => $paginationToken ? ['paginationToken' => $paginationToken] : [],
                ],
                afterRequest: $afterRequest,
            )
        );
    }

    /**
     * Get the statuses for all of a customer’s auto-renewable subscriptions in your app.
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_all_subscription_statuses
     *
     * @param  string  $transactionId
     * @param  array|null  $statuses
     * @param  Closure|null  $afterRequest
     * @return StatusResponse
     * @throws AppStoreServerApiException
     */
    public function getAllSubscriptionStatuses(
        string $transactionId,
        ?array $statuses = null,
        ?Closure $afterRequest = null
    ): StatusResponse {
        return new StatusResponse(
            $this->request(
                api: AppStoreApi::AppStoreServer,
                method: 'GET',
                uri: "/inApps/v1/subscriptions/$transactionId",
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * Download finance reports filtered by your specified criteria.
     * @link https://developer.apple.com/documentation/appstoreconnectapi/get-v1-financereports
     *
     * @param  DownloadFinanceReportsRequest  $request
     * @param  Closure|null  $afterRequest
     * @return ResponseInterface
     */
    public function downloadFinanceReports(
        DownloadFinanceReportsRequest $request,
        string $tmpFile,
        ?Closure $afterRequest = null,
    ) {
        return $this->request(
            api: AppStoreApi::AppStoreConnect,
            method: 'GET',
            uri: '/v1/financeReports',
            options: [
                RequestOptions::QUERY => ['filter' => $request->toResponse()],
                RequestOptions::SINK => $tmpFile,
                'headers' => [
                    'Accept' => '*/*',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Content-Type' => 'application/a-gzip',
                ],
            ],
            afterRequest: $afterRequest,
        );
    }

    /**
     * Download sales and trends reports filtered by your specified criteria.
     * @link https://developer.apple.com/documentation/appstoreconnectapi/get-v1-salesreports
     *
     * @param  DownloadSalesAndTrendsReportsRequest  $request
     * @param  Closure|null  $afterRequest
     * @return ResponseInterface
     */
    public function downloadSalesAndTrendsReports(
        DownloadSalesAndTrendsReportsRequest $request,
        string $tmpFile,
        ?Closure $afterRequest = null,
    ): void {
        $this->request(
            api: AppStoreApi::AppStoreConnect,
            method: 'GET',
            uri: '/v1/salesReports',
            options: [
                RequestOptions::QUERY => ['filter' => $request->toResponse()],
                RequestOptions::SINK => $tmpFile,
                'headers' => ['Accept' => 'application/a-gzip'],
                'decode_content' => false,
            ],
            afterRequest: $afterRequest,
        );
    }

    /**
     * Create an auto-renewable subscription for your app.
     * @link https://developer.apple.com/documentation/appstoreconnectapi/post-v1-subscriptions
     */
    public function createAutoRenewableSubscription(
        SubscriptionCreateRequest $request,
        ?Closure $afterRequest = null,
    ): SubscriptionResponse {
        return new SubscriptionResponse(
            $this->request(
                api: AppStoreApi::AppStoreConnect,
                method: 'POST',
                uri: '/v1/subscriptions',
                options: [
                    RequestOptions::JSON => $request->toRequest(),
                ],
                afterRequest: $afterRequest,
            )
        );
    }

    public function updateAutoRenewableSubscription(
        int $subscriptionId,
        SubscriptionUpdateRequest $request,
        ?Closure $afterRequest = null,
    ) {
        return $this->request(
            api: AppStoreApi::AppStoreConnect,
            method: 'PATCH',
            uri: "/v1/subscriptions/$subscriptionId",
            options: [RequestOptions::JSON => $request->toRequest()],
            afterRequest: $afterRequest,
        );
    }

    /**
     * Create a localized display name and description for an auto-renewable subscription.
     * @link https://developer.apple.com/documentation/appstoreconnectapi/post-v1-subscriptionlocalizations
     */
    public function createSubscriptionLocalization(
        SubscriptionLocalizationCreateRequest $request,
        ?Closure $afterRequest = null,
    ): SubscriptionLocalizationResponse {
        return new SubscriptionLocalizationResponse(
            $this->request(
                api: AppStoreApi::AppStoreConnect,
                method: 'POST',
                uri: '/v1/subscriptionLocalizations',
                options: [
                    RequestOptions::JSON => $request->toRequest(),
                ],
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * Get a list of price points for an auto-renewable subscription by territory.
     * @link https://developer.apple.com/documentation/appstoreconnectapi/get-v1-subscriptions-_id_-pricepoints
     */
    public function getSubscriptionPricePoints(
        int $subscriptionId,
        int $limit = 200,
        ?string $territory = null,
        ?string $cursor = null,
        ?Closure $afterRequest = null,
    ): SubscriptionPricePointsResponse {
        $query = [
            'fields[subscriptionPricePoints]' => 'customerPrice',
            'limit' => $limit,
            'cursor' => $cursor,
        ];
        if (!empty($territory)) {
            $query['filter[territory]'] = trim($territory);
        }
        return new SubscriptionPricePointsResponse(
            $this->request(
                api: AppStoreApi::AppStoreConnect,
                method: 'GET',
                uri: "/v1/subscriptions/$subscriptionId/pricePoints",
                options: [
                    RequestOptions::QUERY => $query,
                ],
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * List all territories where the App Store operates.
     * @link https://developer.apple.com/documentation/appstoreconnectapi/get-v1-territories
     */
    public function getTerritories(
        int $limit = 200,
        ?string $cursor = null,
        ?Closure $afterRequest = null,
    ): TerritoriesResponse {
        $query = [
            'fields[territories]' => 'currency',
            'limit' => $limit,
            'cursor' => $cursor,
        ];
        return new TerritoriesResponse(
            $this->request(
                api: AppStoreApi::AppStoreConnect,
                method: 'GET',
                uri: '/v1/territories',
                options: [
                    RequestOptions::QUERY => $query,
                ],
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * Update the territory availability of a specific subscription.
     * @link https://developer.apple.com/documentation/appstoreconnectapi/post-v1-subscriptionavailabilities
     */
    public function updateSubscriptionAvailabilities(
        SubscriptionAvailabilityCreateRequest $request,
        ?Closure $afterRequest = null,
    ) {
        $this->request(
            api: AppStoreApi::AppStoreConnect,
            method: 'POST',
            uri: '/v1/subscriptionAvailabilities',
            options: [
                RequestOptions::JSON => $request->toRequest(),
            ],
            afterRequest: $afterRequest,
        );
    }

    /**
     * Reserve a review screenshot for an auto-renewable subscription.
     * @link https://developer.apple.com/documentation/appstoreconnectapi/post-v1-subscriptionappstorereviewscreenshots
     */
    public function createReviewScreenshotForSubscription(
        SubscriptionAppStoreReviewScreenshotCreateRequest $request,
        ?Closure $afterRequest = null,
    ): SubscriptionAppStoreReviewScreenshotResponse {
        return new SubscriptionAppStoreReviewScreenshotResponse(
            $this->request(
                api: AppStoreApi::AppStoreConnect,
                method: 'POST',
                uri: '/v1/subscriptionAppStoreReviewScreenshots',
                options: [
                    RequestOptions::JSON => $request->toRequest(),
                ],
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * Commit an uploaded image asset as a review screenshot for an auto-renewable subscription.
     * @link https://developer.apple.com/documentation/appstoreconnectapi/patch-v1-subscriptionappstorereviewscreenshots-_id_
     */
    public function commitReviewScreenshotForSubscription(
        string $screenshotId,
        SubscriptionAppStoreReviewScreenshotUpdateRequest $request,
        ?Closure $afterRequest = null,
    ): SubscriptionAppStoreReviewScreenshotResponse {
        return new SubscriptionAppStoreReviewScreenshotResponse(
            $this->request(
                api: AppStoreApi::AppStoreConnect,
                method: 'PATCH',
                uri: "/v1/subscriptionAppStoreReviewScreenshots/$screenshotId",
                options: [
                    RequestOptions::JSON => $request->toRequest(),
                ],
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * @link https://developer.apple.com/documentation/appstoreconnectapi/get-v1-subscriptionpricepoints-_id_-relationships-equalizations
     */
    public function getSubscriptionPricePointEqualizations(
        string $pricePointId,
        int $limit = 200,
        ?string $cursor = null,
        ?Closure $afterRequest = null,
    ): SubscriptionPricePointEqualizationsLinkagesResponse {
        $query = [
            'fields[subscriptionPricePoints]' => 'customerPrice,territory',
            'include' => 'territory',
            'limit' => $limit,
            'cursor' => $cursor,
        ];
        return new SubscriptionPricePointEqualizationsLinkagesResponse(
            $this->request(
                api: AppStoreApi::AppStoreConnect,
                method: 'GET',
                uri: "v1/subscriptionPricePoints/$pricePointId/equalizations",
                options: [
                    RequestOptions::QUERY => $query,
                ],
                afterRequest: $afterRequest,
            ),
        );
    }

    protected static function serializeRequest(RequestInterface $request): array
    {
        $request->getBody()->rewind();
        return [
            'method' => $request->getMethod(),
            'url' => $request->getUri()->__toString(),
            'body' => $request->getBody()->getContents(),
        ];
    }
}
