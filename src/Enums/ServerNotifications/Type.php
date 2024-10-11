<?php

namespace AppStoreLibrary\Enums\ServerNotifications;

/**
 * The product type of the In-App Purchase.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/type
 */
enum Type: string
{
    /** An auto-renewable subscription. */
    case AutoRenewableSubscription = 'Auto-Renewable Subscription';
    /** A non-consumable In-App Purchase. */
    case NonConsumable = 'Non-Consumable';
    /** A consumable In-App Purchase. */
    case Consumable = 'Consumable';
    /** A non-renewing subscription. */
    case NonRenewingSubscription = 'Non-Renewing Subscription';
}
