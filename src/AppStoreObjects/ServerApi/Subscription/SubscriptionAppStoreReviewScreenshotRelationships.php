<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\AppStoreObjects\ServerApi\Relationship;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionappstorereviewscreenshotcreaterequest/data-data.dictionary/relationships-data.dictionary
 */
class SubscriptionAppStoreReviewScreenshotRelationships
{
    public function __construct(
        public Relationship $subscription,
    ) {
    }

    public function toRequest(): array
    {
        return [
            'subscription' => $this->subscription->toRequest(),
        ];
    }
}
