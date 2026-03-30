<?php

namespace AppStoreLibrary\Requests;

use AppStoreLibrary\AppStoreObjects\ServerApi\Subscription\SubscriptionCreateData;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptioncreaterequest
 */
class SubscriptionCreateRequest
{
    public function __construct(
        public SubscriptionCreateData $data,
    ) {
    }

    public function toRequest(): array
    {
        return ['data' => $this->data->toRequest()];
    }
}
