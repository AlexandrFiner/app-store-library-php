<?php

namespace AppStoreLibrary;

use AppStoreLibrary\Clients\Client;
use AppStoreLibrary\Enums\AppStoreApi;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Exceptions\AppStoreServerApiException;
use AppStoreLibrary\Requests\ConsumptionRequest;
use AppStoreLibrary\Requests\NotificationHistoryRequest;
use AppStoreLibrary\Responses\ConnectApi\SubscriptionGroupsResponse;
use AppStoreLibrary\Responses\ConnectApi\SubscriptionPricesResponse;
use AppStoreLibrary\Responses\ConnectApi\SubscriptionsByGroupResponse;
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
                $request?->getBody()->rewind();
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
        string $cursor = null,
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
        string $cursor = null,
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
        string $cursor = null,
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
