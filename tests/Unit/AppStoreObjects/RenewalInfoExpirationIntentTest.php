<?php

namespace AppStoreLibrary\Tests\Unit\AppStoreObjects;

use AppStoreLibrary\AppStoreObjects\ServerNotifications\JWSRenewalInfoDecodedPayload;
use AppStoreLibrary\AppStoreObjects\StoreKit\JwsRepresentationRenewalInfo;
use AppStoreLibrary\Enums\ServerNotifications\ExpirationIntent;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class RenewalInfoExpirationIntentTest extends TestCase
{
    public static function renewalInfoClassProvider(): array
    {
        return [
            'server notification' => [JWSRenewalInfoDecodedPayload::class],
            'storekit' => [JwsRepresentationRenewalInfo::class],
        ];
    }

    /**
     * @param class-string<JWSRenewalInfoDecodedPayload> $class
     */
    #[DataProvider('renewalInfoClassProvider')]
    public function testCastsToEnum(string $class): void
    {
        $renewalInfo = $class::fromArray(['expirationIntent' => 2]);

        $this->assertSame(ExpirationIntent::BillingError, $renewalInfo->expirationIntent);
    }

    /**
     * @param class-string<JWSRenewalInfoDecodedPayload> $class
     */
    #[DataProvider('renewalInfoClassProvider')]
    public function testUnknownValueIsNull(string $class): void
    {
        $renewalInfo = $class::fromArray(['expirationIntent' => 99]);

        $this->assertNull($renewalInfo->expirationIntent);
    }

    /**
     * @param class-string<JWSRenewalInfoDecodedPayload> $class
     */
    #[DataProvider('renewalInfoClassProvider')]
    public function testMissingValueIsNull(string $class): void
    {
        $renewalInfo = $class::fromArray([]);

        $this->assertNull($renewalInfo->expirationIntent);
    }
}
