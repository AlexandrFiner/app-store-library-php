<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

/**
 * https://developer.apple.com/documentation/appstoreconnectapi/subscriptionavailabilitycreaterequest/data-data.dictionary/attributes-data.dictionary
 */
class SubscriptionAvailabilityAttributes
{
    public function __construct(
        public bool $availableInNewTerritories,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'availableInNewTerritories' => $this->availableInNewTerritories,
        ], static fn ($v) => $v !== null);
    }
}
