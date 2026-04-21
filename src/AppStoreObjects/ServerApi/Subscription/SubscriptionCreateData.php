<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\Enums\ConnectApi\ResourceType;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptioncreaterequest/data-data.dictionary
 */
class SubscriptionCreateData
{
    public protected(set) ResourceType $type = ResourceType::Subscriptions;

    public function __construct(
        public SubscriptionCreateAttributes $attributes,
        public ?SubscriptionRelationships $relationships = null,
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
