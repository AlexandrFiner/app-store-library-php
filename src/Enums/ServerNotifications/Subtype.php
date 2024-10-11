<?php

namespace AppStoreLibrary\Enums\ServerNotifications;

/**
 * A string that provides details about select notification types in version 2.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/subtype
 */
enum Subtype: string
{
    /**
     * A notification with this subtype indicates that the user purchased the subscription for the first time or that
     * the user received access to the subscription through Family Sharing for the first time.
     */
    case InitialBuy = 'INITIAL_BUY';
    /**
     * A notification with this subtype indicates that the user resubscribed or received access through Family Sharing
     * to the same subscription or to another subscription within the same subscription group.
     */
    case Resubscribe = 'RESUBSCRIBE';
    /**
     * A notification with this subtype indicates that the user downgraded their subscription or cross-graded to
     * a subscription with a different duration. Downgrades take effect at the next renewal date.
     */
    case Downgrade = 'DOWNGRADE';
    /**
     * A notification with this subtype indicates that the user upgraded their subscription or cross-graded to
     * a subscription with the same duration. Upgrades take effect immediately.
     */
    case Upgrade = 'UPGRADE';
    /**
     * A notification with this subtype indicates that the user enabled subscription auto-renewal.
     */
    case AutoRenewEnabled = 'AUTO_RENEW_ENABLED';
    /**
     * A notification with this `subtype indicates that the user disabled subscription auto-renewal,
     * or the App Store disabled subscription auto-renewal after the user requested a refund.
     */
    case AutoRenewDisabled = 'AUTO_RENEW_DISABLED';
    /**
     * A notification with this subtype indicates that the subscription expired after the user
     * disabled subscription auto-renewal.
     */
    case Voluntary = 'VOLUNTARY';
    /**
     * A notification with this subtype indicates that the subscription expired because the subscription
     * failed to renew before the billing retry period ended.
     */
    case BillingRetry = 'BILLING_RETRY';
    /**
     * A notification with this subtype indicates that the subscription expired because the user
     * didn’t consent to a price increase.
     */
    case PriceIncrease = 'PRICE_INCREASE';
    /**
     * A notification with this subtype indicates that the subscription failed to renew due to a billing issue.
     * Continue to provide access to the subscription during the grace period.
     */
    case GracePeriod = 'GRACE_PERIOD';
    /**
     * A notification with this subtype indicates that the system informed the user of the subscription price increase,
     * but the user hasn’t accepted it.
     */
    case Pending = 'PENDING';
    /**
     * A notification with this subtype indicates that the customer consented to the subscription price increase
     * if the price increase requires customer consent, or that the system notified them of a price increase
     * if the price increase doesn’t require customer consent.
     */
    case Accepted = 'ACCEPTED';
    /**
     * A notification with this subtype indicates that the expired subscription that previously failed to renew
     * has successfully renewed.
     */
    case BillingRecovery = 'BILLING_RECOVERY';
    /**
     * A notification with this subtype indicates that the subscription expired because the product wasn’t
     * available for purchase at the time the subscription attempted to renew.
     */
    case ProductNotForSale = 'PRODUCT_NOT_FOR_SALE';
    /**
     * A notification with this subtype indicates that the App Store server completed your request to extend the
     * subscription renewal date for all eligible subscribers.
     */
    case Summary = 'SUMMARY';
    /**
     * A notification with this subtype indicates that the subscription-renewal-date extension failed for an
     * individual subscription
     */
    case Failure = 'FAILURE';
    /**
     * A notification with this subtype indicates that Apple created a token for your app but didn’t receive a report
     */
    case Unreported = 'UNREPORTED';

    /**
     * @return NotificationType[]
     */
    public function getAppliesInNotificationTypes(): array
    {
        return match ($this) {
            self::Accepted, self::Pending => [
                NotificationType::PriceIncrease,
            ],
            self::AutoRenewDisabled, self::AutoRenewEnabled => [
                NotificationType::DidChangeRenewalStatus,
            ],
            self::BillingRecovery => [
                NotificationType::DidRenew,
            ],
            self::BillingRetry, self::PriceIncrease, self::ProductNotForSale, self::Voluntary => [
                NotificationType::Expired,
            ],
            self::Downgrade, self::Upgrade => [
                NotificationType::DidChangeRenewalPref,
                NotificationType::OfferRedeemed,
            ],
            self::Failure, self::Summary => [
                NotificationType::RenewalExtension,
            ],
            self::GracePeriod => [
                NotificationType::DidFailToRenew,
            ],
            self::InitialBuy, self::Resubscribe => [
                NotificationType::Subscribed,
            ],
            self::Unreported => [
                NotificationType::ExternalPurchaseToken,
            ],
        };
    }
}
