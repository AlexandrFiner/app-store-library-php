<?php

namespace AppStoreLibrary\Requests;

use AppStoreLibrary\AppStoreObjects\ServerApi\Subscription\SubscriptionAvailabilityCreateData;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionavailabilitycreaterequest
 */
class SubscriptionAvailabilityCreateRequest
{
    public function __construct(
        public SubscriptionAvailabilityCreateData $data,
    ) {
    }

    public function toRequest(): array
    {
        return ['data' => $this->data->toRequest()];
    }
}
