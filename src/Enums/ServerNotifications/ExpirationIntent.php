<?php

namespace AppStoreLibrary\Enums\ServerNotifications;

/**
 * The reason an auto-renewable subscription expired.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/expirationintent
 */
enum ExpirationIntent: int
{
    /** The customer canceled their subscription. */
    case CustomerCanceled = 1;
    /** Billing error; for example, the customer's payment information is no longer valid. */
    case BillingError = 2;
    /** The customer didn't consent to an auto-renewable subscription price increase that requires customer consent. */
    case PriceIncreaseNotConsented = 3;
    /** The product wasn't available for purchase at the time of renewal. */
    case ProductUnavailable = 4;
    /** The subscription expired for some other reason. */
    case Other = 5;
}
