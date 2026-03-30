<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\Enums\ConnectApi\ResourceType;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionappstorereviewscreenshotupdaterequest/data-data.dictionary
 */
class SubscriptionAppStoreReviewScreenshotUpdateData
{
    public protected(set) ResourceType $type = ResourceType::SubscriptionAppStoreReviewScreenshots;

    public function __construct(
        public SubscriptionAppStoreReviewScreenshotUpdateAttributes $attributes,
        public string $id,
    ) {
    }

    public function toRequest(): array
    {
        return [
            'attributes' => $this->attributes->toRequest(),
            'id' => $this->id,
            'type' => $this->type->value,
        ];
    }
}
