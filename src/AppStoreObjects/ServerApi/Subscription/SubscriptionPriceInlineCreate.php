<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\Enums\ConnectApi\ResourceType;

/**
 * https://developer.apple.com/documentation/appstoreconnectapi/subscriptionpriceinlinecreate
 */
class SubscriptionPriceInlineCreate
{
    public ResourceType $type = ResourceType::SubscriptionPrices;

    public function __construct(
        public string $id,
        public ?SubscriptionPriceInlineRelationships $relationships = null,
        public ?SubscriptionPriceCreateAttributes $attributes = null,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'type' => $this->type->value,
            'id' => $this->id,
            'relationships' => $this->relationships?->toRequest(),
            'attributes' => $this->attributes?->toRequest(),
        ], static fn ($v) => $v !== null);
    }
}
