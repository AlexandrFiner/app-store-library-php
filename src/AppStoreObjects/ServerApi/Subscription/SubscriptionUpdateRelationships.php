<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\AppStoreObjects\ServerApi\RelationshipList;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionupdaterequest/data-data.dictionary/relationships-data.dictionary
 */
class SubscriptionUpdateRelationships
{
    public function __construct(
        public ?RelationshipList $introductoryOffers = null,
        public ?RelationshipList $prices = null,
        public ?RelationshipList $promotionalOffers = null,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'introductoryOffers' => $this->introductoryOffers?->toRequest(),
            'prices' => $this->prices?->toRequest(),
            'promotionalOffers' => $this->promotionalOffers?->toRequest(),
        ], static fn ($v) => $v !== null);
    }
}
