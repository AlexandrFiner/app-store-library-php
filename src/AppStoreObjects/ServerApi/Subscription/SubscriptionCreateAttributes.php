<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\Enums\ConnectApi\Subscription\Attributes\Period;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptioncreaterequest/data-data.dictionary/attributes-data.dictionary
 */
class SubscriptionCreateAttributes
{
    public function __construct(
        public string $name,
        public string $productId,
        public ?bool $familySharable = null,
        public ?string $reviewNote = null,
        public ?Period $subscriptionPeriod = null,
        public ?int $groupLevel = null,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'name' => $this->name,
            'productId' => $this->productId,
            'familySharable' => $this->familySharable,
            'reviewNote' => $this->reviewNote,
            'subscriptionPeriod' => $this->subscriptionPeriod?->value,
            'groupLevel' => $this->groupLevel,
        ], static fn ($v) => $v !== null);
    }
}
