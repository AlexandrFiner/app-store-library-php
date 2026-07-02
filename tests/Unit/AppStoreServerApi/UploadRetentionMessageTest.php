<?php

namespace AppStoreLibrary\Tests\Unit\AppStoreServerApi;

use AppStoreLibrary\Clients\FakeClient;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Requests\RetentionMessageBulletPoint;
use AppStoreLibrary\Requests\UploadRetentionMessageImage;
use AppStoreLibrary\Requests\UploadRetentionMessageRequestBody;
use AppStoreLibrary\Sender;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class UploadRetentionMessageTest extends TestCase
{
    /**
     * @throws \Exception
     */
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

        $api->uploadRetentionMessage(
            messageIdentifier: 'msg_01',
            request: new UploadRetentionMessageRequestBody(
                header: 'Keep your plan',
                body: 'New plan available at a better price.',
                image: new UploadRetentionMessageImage('img_01', 'A colorful banner'),
                bulletPoints: [new RetentionMessageBulletPoint('No interruptions', 'img_bp_01', 'A check icon')],
                headerPosition: 'ABOVE_IMAGE',
            ),
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
        $this->assertSame('/inApps/v1/messaging/message/msg_01', $capturedUrl);
        $this->assertSame(
            [
                'header' => 'Keep your plan',
                'body' => 'New plan available at a better price.',
                'image' => [
                    'imageIdentifier' => 'img_01',
                    'altText' => 'A colorful banner',
                ],
                'bulletPoints' => [[
                    'text' => 'No interruptions',
                    'imageIdentifier' => 'img_bp_01',
                    'altText' => 'A check icon',
                ]],
                'headerPosition' => 'ABOVE_IMAGE',
            ],
            $capturedBody
        );
        $this->assertSame(200, $capturedStatusCode);
    }
}
