<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\Enums\ConnectApi\ResourceType;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionintroductoryofferinlinecreate
 */
class SubscriptionIntroductoryOfferInlineCreate
{
    public ResourceType $type = ResourceType::SubscriptionIntroductoryOffers;

    public function __construct(
        public string $id,
        public SubscriptionIntroductoryOfferInlineAttributes $attributes,
        public ?SubscriptionIntroductoryOfferInlineRelationships $relationships,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'type' => $this->type->value,
            'id' => $this->id,
            'attributes' => $this->attributes->toRequest(),
            'relationships' => $this->relationships->toRequest(),
        ], static fn ($v) => $v !== null);
    }
}
