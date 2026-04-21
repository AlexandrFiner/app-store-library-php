<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\Enums\ServerApi\SubscriptionOfferDuration;
use AppStoreLibrary\Enums\ServerApi\SubscriptionOfferMode;
use Carbon\Carbon;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionintroductoryofferinlinecreate/attributes-data.dictionary
 */
class SubscriptionIntroductoryOfferInlineAttributes
{
    public function __construct(
        public SubscriptionOfferDuration $duration,
        public int $numberOfPeriods,
        public SubscriptionOfferMode $offerMode,
        public ?Carbon $startDate = null,
        public ?Carbon $endDate = null,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'duration' => $this->duration->value,
            'numberOfPeriods' => $this->numberOfPeriods,
            'offerMode' => $this->offerMode->value,
            'startDate' => $this->startDate?->toDateString(),
            'endDate' => $this->endDate?->toDateString(),
        ], static fn ($v) => $v !== null);
    }
}
