<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\Enums\ConnectApi\ResourceType;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionappstorereviewscreenshotcreaterequest/data-data.dictionary
 */
class SubscriptionAppStoreReviewScreenshotCreateData
{
    public protected(set) ResourceType $type = ResourceType::SubscriptionAppStoreReviewScreenshots;

    public function __construct(
        public SubscriptionAppStoreReviewScreenshotCreateAttributes $attributes,
        public SubscriptionAppStoreReviewScreenshotRelationships $relationships,
    ) {
    }

    public function toRequest(): array
    {
        return [
            'attributes' => $this->attributes->toRequest(),
            'relationships' => $this->relationships->toRequest(),
            'type' => $this->type->value,
        ];
    }
}
