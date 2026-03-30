<?php

namespace AppStoreLibrary\Tests\Unit\AppStoreConnectApi;

use AppStoreLibrary\Clients\FakeClient;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Responses\ConnectApi\TerritoriesResponse;
use AppStoreLibrary\Sender;
use PHPUnit\Framework\TestCase;

final class TerritoriesTest extends TestCase
{
    public function test(): void
    {
        $filePath = dirname(__DIR__, 2) . '/data/asc/v1_territories.json';
        FakeClient::$responseBody = file_get_contents($filePath);
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
        $result = $api->getTerritories();
        $this->assertInstanceOf(TerritoriesResponse::class, $result);

        $pagination = $result->getPagination();
        $this->assertArrayHasKey('first', $pagination);
        $this->assertArrayHasKey('next', $pagination);
        $this->assertNull($pagination['first']);
        $this->assertNull($pagination['next']);
        $this->assertArrayHasKey('current', $pagination);
        $this->assertNotNull($pagination['current']);
        $current = $pagination['current'];
        $this->assertArrayHasKey('cursor', $current);
        $this->assertNull($current['cursor']);
        $this->assertArrayHasKey('url', $current);
        $this->assertEquals('https://api.appstoreconnect.apple.com/v1/territories?limit=200', $current['url']);

        $data = $result->getData();
        $this->assertIsArray($data);
        $this->assertCount(10, $data);
        $this->assertSame(
            [
                'type' => 'territories',
                'id' => 'AFG',
                'attributes' => [
                    'currency' => 'USD',
                ],
                'links' => [
                    'self' => 'https://api.appstoreconnect.apple.com/v1/territories/AFG',
                ],
            ],
            $data[0],
        );
    }
}
