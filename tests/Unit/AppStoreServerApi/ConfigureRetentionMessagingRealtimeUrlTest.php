<?php

namespace AppStoreLibrary\Tests\Unit\AppStoreServerApi;

use AppStoreLibrary\Clients\FakeClient;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Sender;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ConfigureRetentionMessagingRealtimeUrlTest extends TestCase
{
    public function testSendsExpectedRequest(): void
    {
        FakeClient::$responseBody = '';

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
        $capturedBody = null;
        $capturedStatusCode = null;

        $api->configureRetentionMessagingRealtimeUrl(
            realtimeURL: 'https://example.com/retention-messaging',
            afterRequest: function (
                Carbon $startedAt,
                RequestInterface $request,
                array $options,
                ?ResponseInterface $response,
                ?\Throwable $error
            ) use (&$capturedMethod, &$capturedUrl, &$capturedBody, &$capturedStatusCode): void {
                $capturedMethod = $request->getMethod();
                $capturedUrl = $request->getUri()->__toString();
                $capturedBody = $options['json'] ?? null;
                $capturedStatusCode = $response?->getStatusCode();
            },
        );

        $this->assertSame('PUT', $capturedMethod);
        $this->assertSame('/inApps/v1/messaging/realtime/url', $capturedUrl);
        $this->assertSame(['realtimeURL' => 'https://example.com/retention-messaging'], $capturedBody);
        $this->assertSame(200, $capturedStatusCode);
    }
}
