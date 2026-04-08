<?php

namespace AppStoreLibrary\AppStoreObjects\StoreKit;

use AppStoreLibrary\AppStoreObjects\Property;
use AppStoreLibrary\AppStoreObjects\ServerNotifications\JWSRenewalInfoDecodedPayload;
use AppStoreLibrary\AppStoreObjects\Signable;
use AppStoreLibrary\AppStoreObjects\HasSignable;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Enums\ServerNotifications\OfferDiscountType;
use AppStoreLibrary\Enums\ServerNotifications\OfferType;
use Carbon\Carbon;

/**
 * A decoded payload containing subscription renewal information for an auto-renewable subscription.
 * @link https://developer.apple.com/documentation/storekit/verificationresult/jwsrepresentation-178oj
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
 * @property null|string $deviceVerification
 * @property null|string $deviceVerificationNonce
 */
class JwsRepresentationRenewalInfo extends JWSRenewalInfoDecodedPayload implements Signable
{
    use HasSignable;

    public function __construct()
    {
        parent::__construct();
        $this->properties += [
            'deviceVerification' => new Property(type: 'string'),
            'deviceVerificationNonce' => new Property(type: 'string'),
        ];
    }
}
