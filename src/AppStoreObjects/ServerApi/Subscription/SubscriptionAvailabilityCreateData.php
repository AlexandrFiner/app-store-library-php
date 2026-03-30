<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\Enums\ConnectApi\ResourceType;

/**
 * https://developer.apple.com/documentation/appstoreconnectapi/subscriptionavailabilitycreaterequest/data-data.dictionary
 */
class SubscriptionAvailabilityCreateData
{
    public protected(set) ResourceType $type = ResourceType::SubscriptionAvailabilities;

    public function __construct(
        public SubscriptionAvailabilityAttributes $attributes,
        public ?SubscriptionAvailabilityRelationships $relationships = null,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'attributes' => $this->attributes->toRequest(),
            'relationships' => $this->relationships?->toRequest(),
            'type' => $this->type->value,
        ], static fn ($v) => $v !== null);
    }
}
