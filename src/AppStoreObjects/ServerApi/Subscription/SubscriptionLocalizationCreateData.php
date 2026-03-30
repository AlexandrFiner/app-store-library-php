<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\Enums\ConnectApi\ResourceType;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionlocalizationcreaterequest/data-data.dictionary
 */
class SubscriptionLocalizationCreateData
{
    public protected(set) ResourceType $type = ResourceType::SubscriptionLocalizations;

    public function __construct(
        public SubscriptionLocalizationCreateAttributes $attributes,
        public ?SubscriptionLocalizationRelationships $relationships = null,
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
