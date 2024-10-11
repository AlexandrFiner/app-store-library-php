<?php

namespace AppStoreLibrary\Enums\ServerNotifications;

/**
 * The reason for a refunded transaction.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/revocationreason
 */
enum RevocationReason: int
{
    /** The App Store refunded the transaction on behalf of the customer for other reasons, for example, an accidental purchase. */
    case AccidentalPurchase = 0;
    /** The App Store refunded the transaction on behalf of the customer due to an actual or perceived issue within your app. */
    case PerceivedIssue = 1;
}
