<?php

namespace AppStoreLibrary\Requests;

use AppStoreLibrary\AppStoreObjects\ServerApi\Subscription\SubscriptionIntroductoryOfferInlineCreate;
use AppStoreLibrary\AppStoreObjects\ServerApi\Subscription\SubscriptionPriceInlineCreate;
use AppStoreLibrary\AppStoreObjects\ServerApi\Subscription\SubscriptionUpdateData;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionupdaterequest
 */
class SubscriptionUpdateRequest
{
    /**
     * @param  SubscriptionUpdateData  $data
     * @param  SubscriptionIntroductoryOfferInlineCreate[]|SubscriptionPriceInlineCreate[]|null  $included
     */
    public function __construct(
        public SubscriptionUpdateData $data,
        public ?array $included = null,
    ) {
    }

    public function toRequest(): array
    {
        return [
            'data' => $this->data->toRequest(),
            'included' => array_map(fn($item) => $item->toRequest(), $this->included),
        ];
    }
}
