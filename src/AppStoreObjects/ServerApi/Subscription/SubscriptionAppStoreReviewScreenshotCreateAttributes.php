<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionappstorereviewscreenshotcreaterequest/data-data.dictionary/attributes-data.dictionary
 */
class SubscriptionAppStoreReviewScreenshotCreateAttributes
{
    public function __construct(
        public string $fileName,
        public int $fileSize,
    ) {
    }

    public function toRequest(): array
    {
        return [
            'fileName' => $this->fileName,
            'fileSize' => $this->fileSize,
        ];
    }
}
