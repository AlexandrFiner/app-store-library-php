<?php

namespace AppStoreLibrary\Enums\ServerNotifications;

/**
 * The payment mode for a subscription offer for an auto-renewable subscription.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/offerdiscounttype
 */
enum OfferDiscountType: string
{
    /** A payment mode of a product discount that indicates a free trial. */
    case FreeTrial = 'FREE_TRIAL';
    /** A payment mode of a product discount that customers pay over a single or multiple billing periods. */
    case PayAsYouGo = 'PAY_AS_YOU_GO';
    /** A payment mode of a product discount that customers pay up front. */
    case PayUpFront = 'PAY_UP_FRONT';
}
