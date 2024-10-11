<?php

namespace AppStoreLibrary\AppStoreObjects\ServerNotifications;

use AppStoreLibrary\AppStoreObjects\BaseAppStoreObject;
use AppStoreLibrary\AppStoreObjects\Property;
use AppStoreLibrary\AppStoreObjects\Signable;
use AppStoreLibrary\AppStoreObjects\HasSignable;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Enums\ServerNotifications\InAppOwnershipType;
use AppStoreLibrary\Enums\ServerNotifications\OfferDiscountType;
use AppStoreLibrary\Enums\ServerNotifications\OfferType;
use AppStoreLibrary\Enums\ServerNotifications\RevocationReason;
use AppStoreLibrary\Enums\ServerNotifications\TransactionReason;
use AppStoreLibrary\Enums\ServerNotifications\Type;
use Carbon\Carbon;

/**
 * A decoded payload that contains transaction information.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/jwstransactiondecodedpayload
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
 * @property null|string|TransactionReason $transactionReason
 * @property null|string|Type $type
 * @property null|string $webOrderLineItemId
 */
class JWSTransactionDecodedPayload extends BaseAppStoreObject implements Signable
{
    use HasSignable;

    public function __construct()
    {
        $this->properties = [
            'appAccountToken' => new Property(type: 'string'),
            'bundleId' => new Property(type: 'string'),
            'currency' => new Property(type: 'string'),
            'environment' => new Property(type: Environment::class),
            'expiresDate' => new Property(type: Carbon::class),
            'inAppOwnershipType' => new Property(type: InAppOwnershipType::class),
            'isUpgraded' => new Property(type: 'bool'),
            'offerDiscountType' => new Property(type: OfferDiscountType::class),
            'offerIdentifier' => new Property(type: 'string'),
            'offerType' => new Property(type: OfferType::class),
            'originalPurchaseDate' => new Property(type: Carbon::class),
            'originalTransactionId' => new Property(type: 'string'),
            'price' => new Property(type: 'int'),
            'productId' => new Property(type: 'string'),
            'purchaseDate' => new Property(type: Carbon::class),
            'quantity' => new Property(type: 'int'),
            'revocationDate' => new Property(type: Carbon::class),
            'revocationReason' => new Property(type: RevocationReason::class),
            'signedDate' => new Property(type: Carbon::class),
            'storefront' => new Property(type: 'string'),
            'storefrontId' => new Property(type: 'string'),
            'subscriptionGroupIdentifier' => new Property(type: 'string'),
            'transactionId' => new Property(type: 'string'),
            'transactionReason' => new Property(type: TransactionReason::class),
            'type' => new Property(type: Type::class),
            'webOrderLineItemId' => new Property(type: 'string'),
        ];
    }
}
