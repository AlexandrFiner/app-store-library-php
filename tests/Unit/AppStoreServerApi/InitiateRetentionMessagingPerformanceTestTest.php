<?php

namespace AppStoreLibrary\Tests\Unit\AppStoreServerApi;

use AppStoreLibrary\Clients\FakeClient;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Responses\ServerApi\RetentionMessagingPerformanceTestResponse;
use AppStoreLibrary\Sender;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class InitiateRetentionMessagingPerformanceTestTest extends TestCase
{
    public function testSendsExpectedRequestAndParsesResponse(): void
    {
        FakeClient::$responseBody = json_encode([
            'requestId' => '11111111-2222-3333-4444-555555555555',
            'config' => [
                'responseTimeThreshold' => 700,
                'requestCount' => 25,
            ],
        ]);

        $api = new Sender(
            FakeClient::class,
            Environment::Sandbox,
            [
                'APPSTORE_CONNECT_ISSUER_ID' => 'issuer_id',
                'APPSTORE_CONNECT_BUNDLE_ID' => 'bundle_id',
                'APPSTORE_CONNECT_PRIVATE_KEY' => 'private_key',
                'APPSTORE_CONNECT_KEY_ID' => 'key_id',
            ],
        );

        $capturedMethod = null;
        $capturedUrl = null;
        $capturedBody = null;

        $result = $api->initiateRetentionMessagingPerformanceTest(
            originalTransactionId: '1000001234567890',
            afterRequest: function (
                Carbon $startedAt,
                RequestInterface $request,
                array $options,
                ?ResponseInterface $response,
                ?\Throwable $error
            ) use (&$capturedMethod, &$capturedUrl, &$capturedBody): void {
                $capturedMethod = $request->getMethod();
                $capturedUrl = $request->getUri()->__toString();
                $capturedBody = $options['json'] ?? null;
            },
        );

        $this->assertSame('POST', $capturedMethod);
        $this->assertSame('/inApps/v1/messaging/performanceTest', $capturedUrl);
        $this->assertSame(['originalTransactionId' => '1000001234567890'], $capturedBody);
        $this->assertInstanceOf(RetentionMessagingPerformanceTestResponse::class, $result);
        $this->assertSame('11111111-2222-3333-4444-555555555555', $result->getRequestId());
        $this->assertSame([
            'responseTimeThreshold' => 700,
            'requestCount' => 25,
        ], $result->getConfig());
    }
}
