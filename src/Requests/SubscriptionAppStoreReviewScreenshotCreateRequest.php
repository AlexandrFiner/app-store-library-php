<?php

namespace AppStoreLibrary\Requests;

use AppStoreLibrary\AppStoreObjects\ServerApi\Subscription\SubscriptionAppStoreReviewScreenshotCreateData;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionappstorereviewscreenshotcreaterequest
 */
class SubscriptionAppStoreReviewScreenshotCreateRequest
{
    public function __construct(
        public SubscriptionAppStoreReviewScreenshotCreateData $data,
    ) {
    }

    public function toRequest(): array
    {
        return ['data' => $this->data->toRequest()];
    }
}
