<?php

namespace AppStoreLibrary\Enums\ServerNotifications;

/**
 * A string that describes whether the transaction was purchased by the customer,
 * or is available to them through Family Sharing.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/inappownershiptype
 */
enum InAppOwnershipType: string
{
    /** The transaction belongs to a family member who benefits from service. */
    case FamilyShared = 'FAMILY_SHARED';
    /** The transaction belongs to the purchaser. */
    case Purchased = 'PURCHASED';
}
