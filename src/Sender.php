<?php

namespace AppStoreLibrary;

use AppStoreLibrary\Clients\Client;
use AppStoreLibrary\Clients\RealClient;
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
use GuzzleHttp\Exception\GuzzleException;
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
    ): ResponseInterface {
        $request = new Request($method, $uri);
        $response = $this->clients[$api->value]->request($request, $options);
        return $response;
    }

    /**
     * Get information about a single transaction for your app.
     * https://developer.apple.com/documentation/appstoreserverapi/get_transaction_info
     *
     * @param  string  $transactionId  The identifier of a transaction
     * @return TransactionInfoResponse
     * @throws GuzzleException|\Throwable
     */
    public function getTransactionInfo(string $transactionId): TransactionInfoResponse
    {
        return new TransactionInfoResponse(
            $this->request(
                api: AppStoreApi::AppStoreServer,
                method: 'GET',
                uri: "/inApps/v1/transactions/$transactionId",
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
     * @return SubscriptionGroupsResponse
     * @throws AppStoreServerApiException
     * @throws \Throwable
     */
    public function getAppSubscriptionGroups(
        int $appId,
        int $limit = 200,
        string $cursor = null
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
     * @return SubscriptionsByGroupResponse
     * @throws GuzzleException|\Throwable
     */
    public function getSubscriptionsByGroup(
        int $subscriptionGroupId,
        int $limit = 200,
        string $cursor = null
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
     * @return SubscriptionPricesResponse
     * @throws GuzzleException|\Throwable
     */
    public function getSubscriptionPrices(
        int $subscriptionId,
        int $limit = 200,
        string $cursor = null
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
     * @return void
     * @throws \Throwable
     */
    public function sendConsumptionInformation(string $transactionId, ConsumptionRequest $consumptionRequest): void
    {
        $this->request(
            api: AppStoreApi::AppStoreServer,
            method: 'PUT',
            uri: "/v1/transactions/consumption/$transactionId",
            options: [
                RequestOptions::QUERY => $consumptionRequest->toResponse(),
            ],
        );
    }

    /**
     * Get a list of notifications that the App Store server attempted to send to your server.
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_notification_history
     *
     * @param  NotificationHistoryRequest  $request
     * @param  string  $paginationToken
     * @return NotificationHistoryResponse
     * @throws AppStoreServerApiException
     * @throws \Throwable
     */
    public function getNotificationHistory(
        NotificationHistoryRequest $request,
        string $paginationToken = ''
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
            )
        );
    }

    /**
     * Get the statuses for all of a customer’s auto-renewable subscriptions in your app.
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_all_subscription_statuses
     *
     * @param  string  $transactionId
     * @param  array|null  $statuses
     * @return StatusResponse
     * @throws \Throwable
     */
    public function getAllSubscriptionStatuses(string $transactionId, ?array $statuses = null): StatusResponse
    {
        return new StatusResponse(
            $this->request(
                api: AppStoreApi::AppStoreServer,
                method: 'GET',
                uri: "/inApps/v1/subscriptions/$transactionId",
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
