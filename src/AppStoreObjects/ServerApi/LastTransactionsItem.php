<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi;

use AppStoreLibrary\AppStoreObjects\BaseAppStoreObject;
use AppStoreLibrary\AppStoreObjects\Property;
use AppStoreLibrary\AppStoreObjects\ServerNotifications\JWSRenewalInfoDecodedPayload;
use AppStoreLibrary\AppStoreObjects\ServerNotifications\JWSTransactionDecodedPayload;
use AppStoreLibrary\Enums\ServerNotifications\Status;

/**
 * The most recent App Store-signed transaction information and App Store-signed renewal information for an
 * auto-renewable subscription.
 * @link https://developer.apple.com/documentation/appstoreserverapi/lasttransactionsitem
 *
 * @property null|string $originalTransactionId
 * @property null|int|Status $status
 * @property null|string|JWSRenewalInfoDecodedPayload $signedRenewalInfo
 * @property null|string|JWSTransactionDecodedPayload $signedTransactionInfo
 */
class LastTransactionsItem extends BaseAppStoreObject
{
    public function __construct()
    {
        $this->properties = [
            'originalTransactionId' => new Property(type: 'string'),
            'status' => new Property(type: Status::class),
            'signedRenewalInfo' => new Property(type: JWSRenewalInfoDecodedPayload::class),
            'signedTransactionInfo' => new Property(type: JWSTransactionDecodedPayload::class),
        ];
    }
}
