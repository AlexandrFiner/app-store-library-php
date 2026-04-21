<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\AppStoreObjects\ServerApi\Relationship;
use AppStoreLibrary\AppStoreObjects\ServerApi\RelationshipList;

/**
 * https://developer.apple.com/documentation/appstoreconnectapi/subscriptionavailabilitycreaterequest/data-data.dictionary/relationships-data.dictionary
 */
class SubscriptionAvailabilityRelationships
{
    public function __construct(
        public RelationshipList $availableTerritories,
        public Relationship $subscription,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'availableTerritories' => $this->availableTerritories->toRequest(),
            'subscription' => $this->subscription->toRequest(),
        ], static fn ($v) => $v !== null);
    }
}
