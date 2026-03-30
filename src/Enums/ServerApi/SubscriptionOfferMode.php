<?php

namespace AppStoreLibrary\Enums\ServerApi;

/**
 * A string that indicates the payment mode of a subscription offer.
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionoffermode
 */
enum SubscriptionOfferMode: string
{
    /** A constant that indicates a subscription offer is billed over multiple billing periods. */
    case PayAsYouGo = 'PAY_AS_YOU_GO';
    /** A constant that indicates a subscription offer is billed one time, up front. */
    case PayUpFront = 'PAY_UP_FRONT';
    /** A constant that indicates a subscription offer is a free trial. */
    case FreeTrial = 'FREE_TRIAL';
}
