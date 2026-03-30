<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\AppStoreObjects\ServerApi\Relationship;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionintroductoryofferinlinecreate/relationships-data.dictionary
 */
class SubscriptionIntroductoryOfferInlineRelationships
{
    public function __construct(
        public ?Relationship $subscription = null,
        public ?Relationship $subscriptionPricePoint = null,
        public ?Relationship $territory = null,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'subscription' => $this->subscription?->toRequest(),
            'subscriptionPricePoint' => $this->subscriptionPricePoint?->toRequest(),
            'territory' => $this->territory?->toRequest(),
        ], static fn ($v) => $v !== null);
    }
}
