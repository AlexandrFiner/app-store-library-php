<?php

namespace AppStoreLibrary\Requests;

use AppStoreLibrary\AppStoreObjects\ServerApi\Subscription\SubscriptionAppStoreReviewScreenshotUpdateData;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionappstorereviewscreenshotupdaterequest
 */
class SubscriptionAppStoreReviewScreenshotUpdateRequest
{
    public function __construct(
        public SubscriptionAppStoreReviewScreenshotUpdateData $data,
    ) {
    }

    public function toRequest(): array
    {
        return ['data' => $this->data->toRequest()];
    }
}
