<?php

namespace AppStoreLibrary\ApiImplementations;

use AppStoreLibrary\Enums\AppStoreApi;
use AppStoreLibrary\Requests\ConfigureDefaultRetentionMessageRequest;
use AppStoreLibrary\Requests\ConfigureRetentionMessagingRealtimeUrlRequest;
use AppStoreLibrary\Requests\RetentionMessagingPerformanceTestRequest;
use AppStoreLibrary\Requests\UploadRetentionMessageRequestBody;
use AppStoreLibrary\Responses\ServerApi\DefaultRetentionMessageConfigurationResponse;
use AppStoreLibrary\Responses\ServerApi\GetRetentionMessageListResponse;
use AppStoreLibrary\Responses\ServerApi\RetentionMessagingPerformanceTestResponse;
use AppStoreLibrary\Responses\ServerApi\RetentionMessagingPerformanceTestResultResponse;
use AppStoreLibrary\Responses\ServerApi\RetentionMessagingRealtimeUrlResponse;
use Closure;
use GuzzleHttp\RequestOptions;

trait RetentionMessagingApi
{
    /**
     * Configures a default message for a specific product in a specific locale.
     * @link https://developer.apple.com/documentation/retentionmessaging/configure-default-message
     */
    public function configureDefaultRetentionMessage(
        string $productId,
        string $locale,
        string $messageIdentifier,
        ?Closure $afterRequest = null,
    ): void {
        $request = new ConfigureDefaultRetentionMessageRequest($messageIdentifier);

        $this->request(
            api: AppStoreApi::AppStoreServer,
            method: 'PUT',
            uri: "/inApps/v1/messaging/default/$productId/$locale",
            options: [
                RequestOptions::JSON => $request->toResponse(),
            ],
            afterRequest: $afterRequest,
        );
    }

    /**
     * Configures the URL for your Get Retention Message endpoint in the sandbox and production environments.
     * @link https://developer.apple.com/documentation/retentionmessaging/configure-realtime-url
     */
    public function configureRetentionMessagingRealtimeUrl(
        string $realtimeURL,
        ?Closure $afterRequest = null,
    ): void {
        $request = new ConfigureRetentionMessagingRealtimeUrlRequest($realtimeURL);

        $this->request(
            api: AppStoreApi::AppStoreServer,
            method: 'PUT',
            uri: '/inApps/v1/messaging/realtime/url',
            options: [
                RequestOptions::JSON => $request->toResponse(),
            ],
            afterRequest: $afterRequest,
        );
    }

    /**
     * Gets the URL for real-time messages that points to your Get Retention Message endpoint, which you previously configured.
     * @link https://developer.apple.com/documentation/retentionmessaging/get-realtime-url
     */
    public function getRetentionMessagingRealtimeUrl(?Closure $afterRequest = null): RetentionMessagingRealtimeUrlResponse
    {
        return new RetentionMessagingRealtimeUrlResponse(
            $this->request(
                api: AppStoreApi::AppStoreServer,
                method: 'GET',
                uri: '/inApps/v1/messaging/realtime/url',
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * Deletes the URL for your Get Retention Message endpoint, in the sandbox or production environments.
     * @link https://developer.apple.com/documentation/retentionmessaging/delete-realtime-url
     */
    public function deleteRetentionMessagingRealtimeUrl(?Closure $afterRequest = null): void
    {
        $this->request(
            api: AppStoreApi::AppStoreServer,
            method: 'DELETE',
            uri: '/inApps/v1/messaging/realtime/url',
            afterRequest: $afterRequest,
        );
    }

    /**
     * Upload a message to use for retention messaging.
     * @link https://developer.apple.com/documentation/retentionmessaging/upload-message
     */
    public function uploadRetentionMessage(
        string $messageIdentifier,
        UploadRetentionMessageRequestBody $request,
        ?Closure $afterRequest = null,
    ): void {
        $this->request(
            api: AppStoreApi::AppStoreServer,
            method: 'PUT',
            uri: "/inApps/v1/messaging/message/$messageIdentifier",
            options: [
                RequestOptions::JSON => $request->toResponse(),
            ],
            afterRequest: $afterRequest,
        );
    }

    /**
     * Delete a previously uploaded message.
     * @link https://developer.apple.com/documentation/retentionmessaging/delete-message
     */
    public function deleteRetentionMessage(
        string $messageIdentifier,
        ?Closure $afterRequest = null,
    ): void {
        $this->request(
            api: AppStoreApi::AppStoreServer,
            method: 'DELETE',
            uri: "/inApps/v1/messaging/message/$messageIdentifier",
            afterRequest: $afterRequest,
        );
    }

    /**
     * Get the message identifier and state of all uploaded messages.
     * @link https://developer.apple.com/documentation/retentionmessaging/get-message-list
     */
    public function getRetentionMessageList(?Closure $afterRequest = null): GetRetentionMessageListResponse
    {
        return new GetRetentionMessageListResponse(
            $this->request(
                api: AppStoreApi::AppStoreServer,
                method: 'GET',
                uri: '/inApps/v1/messaging/message/list',
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * Gets the default message for a specific product in a specific locale, if it’s configured.
     * @link https://developer.apple.com/documentation/retentionmessaging/get-default-message
     */
    public function getDefaultRetentionMessage(
        string $productId,
        string $locale,
        ?Closure $afterRequest = null,
    ): DefaultRetentionMessageConfigurationResponse {
        return new DefaultRetentionMessageConfigurationResponse(
            $this->request(
                api: AppStoreApi::AppStoreServer,
                method: 'GET',
                uri: "/inApps/v1/messaging/default/$productId/$locale",
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * Deletes a default message for a product in a locale.
     * @link https://developer.apple.com/documentation/retentionmessaging/delete-default-message
     */
    public function deleteDefaultRetentionMessage(
        string $productId,
        string $locale,
        ?Closure $afterRequest = null,
    ): void {
        $this->request(
            api: AppStoreApi::AppStoreServer,
            method: 'DELETE',
            uri: "/inApps/v1/messaging/default/$productId/$locale",
            afterRequest: $afterRequest,
        );
    }

    /**
     * Initiates a performance test of your Get Retention Message endpoint in the sandbox environment.
     * @link https://developer.apple.com/documentation/retentionmessaging/initiate-performance-test
     */
    public function initiateRetentionMessagingPerformanceTest(
        string $originalTransactionId,
        ?Closure $afterRequest = null,
    ): RetentionMessagingPerformanceTestResponse {
        $request = new RetentionMessagingPerformanceTestRequest($originalTransactionId);

        return new RetentionMessagingPerformanceTestResponse(
            $this->request(
                api: AppStoreApi::AppStoreServer,
                method: 'POST',
                uri: '/inApps/v1/messaging/performanceTest',
                options: [
                    RequestOptions::JSON => $request->toResponse(),
                ],
                afterRequest: $afterRequest,
            ),
        );
    }

    /**
     * Gets the results of the performance test for the specified request identifier.
     * @link https://developer.apple.com/documentation/retentionmessaging/get-performance-test-results
     */
    public function getRetentionMessagingPerformanceTestResults(
        string $requestId,
        ?Closure $afterRequest = null,
    ): RetentionMessagingPerformanceTestResultResponse {
        return new RetentionMessagingPerformanceTestResultResponse(
            $this->request(
                api: AppStoreApi::AppStoreServer,
                method: 'GET',
                uri: "/inApps/v1/messaging/performanceTest/result/$requestId",
                afterRequest: $afterRequest,
            ),
        );
    }
}
