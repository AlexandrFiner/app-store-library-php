<?php

namespace AppStoreLibrary\Tests\Unit\AppStoreServerApi;

use AppStoreLibrary\Clients\FakeClient;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Responses\ServerApi\RetentionMessagingRealtimeUrlResponse;
use AppStoreLibrary\Sender;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class GetRetentionMessagingRealtimeUrlTest extends TestCase
{
    public function testSendsExpectedRequestAndParsesResponse(): void
    {
        FakeClient::$responseBody = json_encode([
            'realtimeURL' => 'https://example.com/retention-messaging',
        ]);

        $api = new Sender(
            FakeClient::class,
            Environment::Production,
            [
                'APPSTORE_CONNECT_ISSUER_ID' => 'issuer_id',
                'APPSTORE_CONNECT_BUNDLE_ID' => 'bundle_id',
                'APPSTORE_CONNECT_PRIVATE_KEY' => 'private_key',
                'APPSTORE_CONNECT_KEY_ID' => 'key_id',
            ],
        );

        $capturedMethod = null;
        $capturedUrl = null;

        $result = $api->getRetentionMessagingRealtimeUrl(
            afterRequest: function (
                Carbon $startedAt,
                RequestInterface $request,
                array $options,
                ?ResponseInterface $response,
                ?\Throwable $error
            ) use (&$capturedMethod, &$capturedUrl): void {
                $capturedMethod = $request->getMethod();
                $capturedUrl = $request->getUri()->__toString();
            },
        );

        $this->assertSame('GET', $capturedMethod);
        $this->assertSame('/inApps/v1/messaging/realtime/url', $capturedUrl);
        $this->assertInstanceOf(RetentionMessagingRealtimeUrlResponse::class, $result);
        $this->assertSame('https://example.com/retention-messaging', $result->getRealtimeUrl());
    }
}
