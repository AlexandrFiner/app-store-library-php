<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi;

use AppStoreLibrary\AppStoreObjects\BaseAppStoreObject;
use AppStoreLibrary\AppStoreObjects\Property;
use Illuminate\Support\Collection;

/**
 * Information for auto-renewable subscriptions, including signed transaction information and signed renewal
 * information, for one subscription group.
 * @link https://developer.apple.com/documentation/appstoreserverapi/subscriptiongroupidentifieritem
 *
 * @property string $subscriptionGroupIdentifier
 * @property Collection<LastTransactionsItem> $lastTransactions
 */
class SubscriptionGroupIdentifierItem extends BaseAppStoreObject
{
    public function __construct()
    {
        $this->properties = [
            'subscriptionGroupIdentifier' => new Property(type: 'string'),
            'lastTransactions' => new Property(type: Collection::class, arrayItemType: LastTransactionsItem::class),
        ];
    }
}
