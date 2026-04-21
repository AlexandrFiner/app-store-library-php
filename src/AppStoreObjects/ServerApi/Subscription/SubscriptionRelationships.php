<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi\Subscription;

use AppStoreLibrary\AppStoreObjects\ServerApi\Relationship;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptioncreaterequest/data-data.dictionary/relationships-data.dictionary
 */
class SubscriptionRelationships
{
    public function __construct(
        public Relationship $group,
    ) {
    }

    public function toRequest(): array
    {
        return array_filter([
            'group' => $this->group->toRequest(),
        ], static fn ($v) => $v !== null);
    }
}
