<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\Enums\ConnectApi\Subscription\Attributes\Period;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionupdaterequest/data-data.dictionary/attributes-data.dictionary
 */
class SubscriptionUpdateAttributes
{
    public function __construct(
        public ?bool $familySharable = null,
        public ?string $name = null,
        public ?string $reviewNote = null,
        public ?Period $subscriptionPeriod = null,
        public ?int $groupLevel = null,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'familySharable' => $this->familySharable,
            'name' => $this->name,
            'reviewNote' => $this->reviewNote,
            'subscriptionPeriod' => $this->subscriptionPeriod,
            'groupLevel' => $this->groupLevel,
        ], static fn ($v) => $v !== null);
    }
}
