<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\Enums\ConnectApi\ResourceType;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionupdaterequest/data-data.dictionary
 */
class SubscriptionUpdateData
{
    public protected(set) ResourceType $type = ResourceType::Subscriptions;

    public function __construct(
        public string $id,
        public ?SubscriptionUpdateAttributes $attributes = null,
        public ?SubscriptionUpdateRelationships $relationships = null,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'type' => $this->type->value,
            'id' => $this->id,
            'attributes' => $this->attributes?->toRequest(),
            'relationships' => $this->relationships?->toRequest(),
        ], static fn ($v) => $v !== null);
    }
}
