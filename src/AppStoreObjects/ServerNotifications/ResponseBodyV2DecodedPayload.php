<?php

namespace AppStoreLibrary\AppStoreObjects\ServerNotifications;

use AppStoreLibrary\AppStoreObjects\BaseAppStoreObject;
use AppStoreLibrary\AppStoreObjects\Property;
use AppStoreLibrary\AppStoreObjects\Signable;
use AppStoreLibrary\AppStoreObjects\HasSignable;
use AppStoreLibrary\Enums\ServerNotifications\NotificationType;
use AppStoreLibrary\Enums\ServerNotifications\Subtype;
use Carbon\Carbon;

/**
 * A decoded payload that contains the version 2 notification data.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/responsebodyv2decodedpayload
 *
 * @property null|string|NotificationType $notificationType
 * @property null|string|Subtype $subtype
 * @property null|array|ResponseBodyV2Data $data
 * @property null|string $summary
 * @property null|string $externalPurchaseToken
 * @property null|string $version
 * @property null|int|Carbon $signedDate
 * @property null|string $notificationUUID
 */
class ResponseBodyV2DecodedPayload extends BaseAppStoreObject implements Signable
{
    use HasSignable;

    public function __construct()
    {
        $this->properties = [
            'notificationType' => new Property(type: NotificationType::class),
            'subtype' => new Property(type: Subtype::class),
            'data' => new Property(type: ResponseBodyV2Data::class),
            'summary' => new Property(type: 'string'),
            'externalPurchaseToken' => new Property(type: 'string'),
            'version' => new Property(type: 'string'),
            'signedDate' => new Property(type: Carbon::class),
            'notificationUUID' => new Property(type: 'string'),
        ];
    }
}
