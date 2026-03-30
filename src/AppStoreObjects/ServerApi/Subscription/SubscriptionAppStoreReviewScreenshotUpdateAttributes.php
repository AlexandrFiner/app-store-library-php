<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\Enums\ConnectApi\ResourceType;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionappstorereviewscreenshotupdaterequest/data-data.dictionary/attributes-data.dictionary
 */
class SubscriptionAppStoreReviewScreenshotUpdateAttributes
{
    public protected(set) ResourceType $type = ResourceType::SubscriptionAppStoreReviewScreenshots;

    public function __construct(
        public string $sourceFileChecksum,
        public bool $uploaded,
    ) {
    }

    public function toRequest(): array
    {
        return [
            'sourceFileChecksum' => $this->sourceFileChecksum,
            'uploaded' => $this->uploaded,
        ];
    }
}
