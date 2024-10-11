<?php

namespace AppStoreLibrary\AppStoreObjects\StoreKit;

use AppStoreLibrary\AppStoreObjects\Property;
use AppStoreLibrary\AppStoreObjects\ServerNotifications\JWSTransactionDecodedPayload;
use AppStoreLibrary\AppStoreObjects\Signable;
use AppStoreLibrary\AppStoreObjects\HasSignable;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Enums\ServerNotifications\InAppOwnershipType;
use AppStoreLibrary\Enums\ServerNotifications\OfferDiscountType;
use AppStoreLibrary\Enums\ServerNotifications\OfferType;
use AppStoreLibrary\Enums\ServerNotifications\RevocationReason;
use AppStoreLibrary\Enums\ServerNotifications\Type;
use Carbon\Carbon;

/**
 * A decoded payload that contains transaction information.
 * @link https://developer.apple.com/documentation/storekit/verificationresult/3868429-jwsrepresentation
 *
 * @property null|string $appAccountToken
 * @property null|string $bundleId
 * @property null|string $currency
 * @property null|string|Environment $environment
 * @property null|int|Carbon $expiresDate
 * @property null|string|InAppOwnershipType $inAppOwnershipType
 * @property null|bool $isUpgraded
 * @property null|string|OfferDiscountType $offerDiscountType
 * @property null|string $offerIdentifier
 * @property null|int|OfferType $offerType
 * @property null|int|Carbon $originalPurchaseDate
 * @property null|string $originalTransactionId
 * @property null|int $price
 * @property null|string $productId
 * @property null|int|Carbon $purchaseDate
 * @property null|string $quantity
 * @property null|int|Carbon $revocationDate
 * @property null|int|RevocationReason $revocationReason
 * @property null|int|Carbon $signedDate
 * @property null|string $storefront
 * @property null|string $storefrontId
 * @property null|string $subscriptionGroupIdentifier
 * @property null|string $transactionId
 * @property null|string $transactionReason
 * @property null|string|Type $type
 * @property null|string $webOrderLineItemId
 * @property null|string $deviceVerification
 * @property null|string $deviceVerificationNonce
 */

class JwsRepresentationTransaction extends JWSTransactionDecodedPayload implements Signable
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
