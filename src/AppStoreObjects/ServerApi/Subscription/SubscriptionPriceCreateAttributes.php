<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use Carbon\Carbon;

/**
 * https://developer.apple.com/documentation/appstoreconnectapi/subscriptionupdaterequest/data-data.dictionary/attributes-data.dictionary
 */
class SubscriptionPriceCreateAttributes
{
    public function __construct(
        public ?Carbon $startDate = null,
        public ?bool $preserveCurrentPrice = null,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'startDate' => $this->startDate?->toDateString(),
            'preserveCurrentPrice' => $this->preserveCurrentPrice,
        ], static fn ($v) => $v !== null);
    }
}
