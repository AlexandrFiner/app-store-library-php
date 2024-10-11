<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi;

use AppStoreLibrary\AppStoreObjects\BaseAppStoreObject;
use AppStoreLibrary\AppStoreObjects\Property;
use AppStoreLibrary\AppStoreObjects\ServerNotifications\ResponseBodyV2DecodedPayload;
use AppStoreLibrary\Enums\ServerApi\SendAttemptResult;
use Illuminate\Support\Collection;

/**
 * The App Store server notification history record, including the signed notification payload and the result
 * of the server’s first send attempt.
 * @link https://developer.apple.com/documentation/appstoreserverapi/notificationhistoryresponseitem
 *
 * @property null|array<SendAttemptItem> $sendAttempts
 * @property null|string|ResponseBodyV2DecodedPayload $signedPayload
 * @property null|string|SendAttemptResult $firstSendAttemptResult
 */
class NotificationHistoryResponseItem extends BaseAppStoreObject
{
    public function __construct()
    {
        $this->properties = [
            'sendAttempts' => new Property(type: Collection::class, arrayItemType: SendAttemptItem::class),
            'signedPayload' => new Property(type: ResponseBodyV2DecodedPayload::class),
            'firstSendAttemptResult' => new Property(type: SendAttemptResult::class),
        ];
    }
}
