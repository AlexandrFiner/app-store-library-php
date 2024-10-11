<?php

namespace AppStoreLibrary\Enums\ServerNotifications;

/**
 * The cause of a purchase transaction, which indicates whether it’s a customer’s purchase or a renewal
 * for an auto-renewable subscription that the system initiates.
 *
 * @link https://developer.apple.com/documentation/appstoreservernotifications/transactionreason
 */
enum TransactionReason: string
{
    /** The customer initiated the purchase, which may be for any in-app purchase type: consumable, non-consumable, non-renewing subscription, or auto-renewable subscription. */
    case Purchase = 'PURCHASE';
    /** The App Store server initiated the purchase transaction to renew an auto-renewable subscription. */
    case Renewal = 'RENEWAL';
}
