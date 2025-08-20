<?php

namespace AppStoreLibrary\Requests\RetentionMessaging;

use AppStoreLibrary\AppStoreObjects\BaseAppStoreObject;
use AppStoreLibrary\AppStoreObjects\HasSignable;
use AppStoreLibrary\AppStoreObjects\Property;
use AppStoreLibrary\AppStoreObjects\Signable;

/**
 * @property string $originalTransactionId
 * @property int $appAppleId
 * @property string $productId
 * @property string $userLocale
 * @property string $requestIdentifier
 */
class RealtimeRequest extends BaseAppStoreObject implements Signable
{
    use HasSignable;

    public function __construct()
    {
        $this->properties = [
            'originalTransactionId' => new Property(type: 'string'),
            'appAppleId' => new Property(type: 'int'),
            'productId' => new Property(type: 'string'),
            'userLocale' => new Property(type: 'string'),
            'requestIdentifier' => new Property(type: 'string'),
        ];
    }
}