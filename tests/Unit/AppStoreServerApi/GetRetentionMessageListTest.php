<?php

namespace AppStoreLibrary\Tests\Unit\AppStoreServerApi;

use AppStoreLibrary\Clients\FakeClient;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Responses\ServerApi\GetRetentionMessageListResponse;
use AppStoreLibrary\Sender;
use PHPUnit\Framework\TestCase;

final class GetRetentionMessageListTest extends TestCase
{
    public function testSendsExpectedRequestAndParsesResponse(): void
    {
        FakeClient::$responseBody = json_encode([
            'messageIdentifiers' => [
                [
                    'messageIdentifier' => 'msg_01',
                    'state' => 'READY',
                ],
                [
                    'messageIdentifier' => 'msg_02',
                    'state' => 'IN_USE',
                ],
            ],
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

        $result = $api->getRetentionMessageList();
        $this->assertInstanceOf(GetRetentionMessageListResponse::class, $result);
        $this->assertSame(
            [
                [
                    'messageIdentifier' => 'msg_01',
                    'state' => 'READY',
                ],
                [
                    'messageIdentifier' => 'msg_02',
                    'state' => 'IN_USE',
                ],
            ],
            $result->getData(),
        );
    }
}
