<?php

namespace AppStoreLibrary\AppStoreObjects\ServerNotifications;

use AppStoreLibrary\AppStoreObjects\BaseAppStoreObject;
use AppStoreLibrary\AppStoreObjects\Property;
use AppStoreLibrary\Enums\ServerNotifications\ConsumptionRequestReason;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Enums\ServerNotifications\Status;

/**
 * The payload data that contains app metadata and the signed renewal and transaction information.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/data
 *
 * @property null|int $appAppleId
 * @property null|string $bundleId
 * @property null|string $bundleVersion
 * @property null|string|ConsumptionRequestReason $consumptionRequestReason
 * @property null|string|Environment $environment
 * @property null|string|JWSRenewalInfoDecodedPayload $signedRenewalInfo
 * @property null|string|JWSTransactionDecodedPayload $signedTransactionInfo
 * @property null|int|Status $status
 */
class ResponseBodyV2Data extends BaseAppStoreObject
{
    public function __construct()
    {
        $this->properties = [
            'appAppleId' => new Property(type: 'int'),
            'bundleId' => new Property(type: 'string'),
            'bundleVersion' => new Property(type: 'string'),
            'consumptionRequestReason' => new Property(type: ConsumptionRequestReason::class),
            'environment' =>  new Property(type: Environment::class),
            'signedRenewalInfo' => new Property(type: JWSRenewalInfoDecodedPayload::class),
            'signedTransactionInfo' => new Property(type: JWSTransactionDecodedPayload::class),
            'status' => new Property(type: Status::class),
        ];
    }
}
