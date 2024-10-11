<?php

namespace AppStoreLibrary\Enums\ServerNotifications;

/**
 * The status of an auto-renewable subscription at the time the App Store signs the notification.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/status
 */
enum Status: int
{
    /** The auto-renewable subscription is active. */
    case Active = 1;
    /** The auto-renewable subscription is expired. */
    case Expired = 2;
    /** The auto-renewable subscription is in a billing retry period. */
    case BillingRetryPeriod = 3;
    /** The auto-renewable subscription is in a Billing Grace Period. */
    case BillingGracePeriod = 4;
    /** The auto-renewable subscription is revoked. */
    case Revoked = 5;
}
