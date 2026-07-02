<?php

namespace AppStoreLibrary\Tests\Unit\AppStoreServerApi;

use AppStoreLibrary\Clients\FakeClient;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Sender;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class DeleteDefaultRetentionMessageTest extends TestCase
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
        $capturedStatusCode = null;

        $api->deleteDefaultRetentionMessage(
            productId: 'com.example.subscription.monthly',
            locale: 'en-US',
            afterRequest: function (
                Carbon $startedAt,
                RequestInterface $request,
                array $options,
                ?ResponseInterface $response,
                ?\Throwable $error
            ) use (&$capturedMethod, &$capturedUrl, &$capturedStatusCode): void {
                $capturedMethod = $request->getMethod();
                $capturedUrl = $request->getUri()->__toString();
                $capturedStatusCode = $response?->getStatusCode();
            },
        );

        $this->assertSame('DELETE', $capturedMethod);
        $this->assertSame(
            '/inApps/v1/messaging/default/com.example.subscription.monthly/en-US',
            $capturedUrl
        );
        $this->assertSame(200, $capturedStatusCode);
    }
}
