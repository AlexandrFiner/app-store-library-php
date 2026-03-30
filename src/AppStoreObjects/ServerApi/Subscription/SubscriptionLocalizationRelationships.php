<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\AppStoreObjects\ServerApi\Relationship;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionlocalizationcreaterequest/data-data.dictionary/relationships-data.dictionary
 */
class SubscriptionLocalizationRelationships
{
    public function __construct(
        public Relationship $subscription,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'subscription' => $this->subscription->toRequest(),
        ], static fn ($v) => $v !== null);
    }
}
