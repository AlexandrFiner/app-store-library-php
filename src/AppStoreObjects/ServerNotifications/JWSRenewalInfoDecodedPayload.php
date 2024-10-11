<?php

namespace AppStoreLibrary\AppStoreObjects\ServerNotifications;

use AppStoreLibrary\AppStoreObjects\BaseAppStoreObject;
use AppStoreLibrary\AppStoreObjects\Property;
use AppStoreLibrary\AppStoreObjects\Signable;
use AppStoreLibrary\AppStoreObjects\HasSignable;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Enums\ServerNotifications\OfferDiscountType;
use AppStoreLibrary\Enums\ServerNotifications\OfferType;
use Carbon\Carbon;

/**
 * A decoded payload containing subscription renewal information for an auto-renewable subscription.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/jwsrenewalinfodecodedpayload
 *
 * @property null|string $autoRenewProductId
 * @property null|int $autoRenewStatus
 * @property null|string $currency
 * @property null|array<int> $eligibleWinBackOfferIds
 * @property null|string|Environment $environment
 * @property null|int $expirationIntent
 * @property null|int|Carbon $gracePeriodExpiresDate
 * @property null|bool $isInBillingRetryPeriod
 * @property null|string|OfferDiscountType $offerDiscountType
 * @property null|string $offerIdentifier
 * @property null|int|OfferType $offerType
 * @property null|string $originalTransactionId
 * @property null|int $priceIncreaseStatus
 * @property null|string $productId
 * @property null|int|Carbon $recentSubscriptionStartDate
 * @property null|int|Carbon $renewalDate
 * @property null|int $renewalPrice
 * @property null|int|Carbon $signedDate
 */
class JWSRenewalInfoDecodedPayload extends BaseAppStoreObject implements Signable
{
    use HasSignable;

    public function __construct()
    {
        $this->properties = [
            'autoRenewProductId' => new Property(type: 'string'),
            'autoRenewStatus' => new Property(type: 'int'),
            'currency' => new Property(type: 'string'),
            'eligibleWinBackOfferIds' => new Property(type: 'array', arrayItemType: 'int'),
            'environment' => new Property(type: Environment::class),
            'expirationIntent' => new Property(type: 'int'),
            'gracePeriodExpiresDate' => new Property(type: Carbon::class),
            'isInBillingRetryPeriod' => new Property(type: 'bool'),
            'offerDiscountType' => new Property(type: OfferDiscountType::class),
            'offerIdentifier' => new Property(type: 'string'),
            'offerType' => new Property(type: OfferType::class),
            'originalTransactionId' => new Property(type: 'string'),
            'priceIncreaseStatus' => new Property(type: 'int'),
            'productId' => new Property(type: 'string'),
            'recentSubscriptionStartDate' => new Property(type: Carbon::class),
            'renewalDate' => new Property(type: Carbon::class),
            'renewalPrice' => new Property(type: 'int'),
            'signedDate' => new Property(type: Carbon::class),
        ];
    }
}
