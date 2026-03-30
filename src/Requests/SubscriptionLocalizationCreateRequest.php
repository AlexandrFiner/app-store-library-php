<?php

namespace AppStoreLibrary\Requests;

use AppStoreLibrary\AppStoreObjects\ServerApi\Subscription\SubscriptionLocalizationCreateData;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionlocalizationcreaterequest
 */
class SubscriptionLocalizationCreateRequest
{
    public function __construct(
        public SubscriptionLocalizationCreateData $data,
    ) {
    }

    public function toRequest(): array
    {
        return ['data' => $this->data->toRequest()];
    }
}
