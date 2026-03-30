<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\AppStoreObjects\ServerApi\Relationship;

class SubscriptionPriceInlineRelationships
{
    public function __construct(
        public Relationship $subscription,
        public Relationship $subscriptionPricePoint,
        public ?Relationship $territory = null,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'subscription' => $this->subscription->toRequest(),
            'subscriptionPricePoint' => $this->subscriptionPricePoint->toRequest(),
            'territory' => $this->territory?->toRequest(),
        ], static fn ($v) => $v !== null);
    }
}
