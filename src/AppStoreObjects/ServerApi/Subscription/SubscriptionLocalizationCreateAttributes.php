<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionlocalizationcreaterequest/data-data.dictionary/attributes-data.dictionary
 */
class SubscriptionLocalizationCreateAttributes
{
    public function __construct(
        public string $locale,
        public string $name,
        public ?string $description = null,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'locale' => $this->locale,
            'name' => $this->name,
            'description' => $this->description,
        ], static fn ($v) => $v !== null);
    }
}
