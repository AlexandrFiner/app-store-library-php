<?php

namespace AppStoreLibrary\Enums\ServerNotifications;

/**
 * The type of subscription offer.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/offertype
 */
enum OfferType: int
{
    /** An introductory offer. */
    case IntroductoryOffer = 1;
    /** A promotional offer. */
    case PromotionalOffer = 2;
    /** An offer with a subscription offer code. */
    case SubscriptionCodeOffer = 3;
    /** A win-back offer. */
    case WinBackOffer = 4;

    public function isHasOfferIdentifier(): bool
    {
        return in_array($this, [
            self::PromotionalOffer,
            self::SubscriptionCodeOffer,
            self::WinBackOffer,
        ]);
    }
}
