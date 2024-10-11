<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi;

use AppStoreLibrary\AppStoreObjects\BaseAppStoreObject;
use AppStoreLibrary\AppStoreObjects\Property;
use AppStoreLibrary\Enums\ServerApi\SendAttemptResult;
use Carbon\Carbon;

/**
 * The success or error information and the date the App Store server records when it attempts to send
 * a server notification to your server.
 * @link https://developer.apple.com/documentation/appstoreserverapi/sendattemptitem
 *
 * @property null|int|Carbon $attemptDate
 * @property null|string|SendAttemptResult $sendAttemptResult
 */
class SendAttemptItem extends BaseAppStoreObject
{
    public function __construct()
    {
        $this->properties = [
            'attemptDate' => new Property(type: Carbon::class),
            'sendAttemptResult' => new Property(type: SendAttemptResult::class),
        ];
    }
}
