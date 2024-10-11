<?php

namespace AppStoreLibrary\Enums\ServerNotifications;

use AppStoreLibrary\Enums\AppStoreNotificationSubtype;
use AppStoreLibrary\Enums\ServerNotifications\Subtype as NotificationSubType;

/**
 * The type that describes the in-app purchase or external purchase event
 * for which the App Store sends the version 2 notification.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/notificationtype
 */
enum NotificationType: string
{
    /** Customer initiated a refund for a consumable in-app purchase */
    case ConsumptionRequest = 'CONSUMPTION_REQUEST';
    /** Customer makes a change to their renewal plan */
    case DidChangeRenewalPref = 'DID_CHANGE_RENEWAL_PREF';
    /** Customer made a change to the subscription renewal status */
    case DidChangeRenewalStatus = 'DID_CHANGE_RENEWAL_STATUS';
    /** Customer fails to renew a subscription due to a billing issue */
    case DidFailToRenew = 'DID_FAIL_TO_RENEW';
    /** Customer successfully renews their subscription  */
    case DidRenew = 'DID_RENEW';
    /** Subscription expires */
    case Expired = 'EXPIRED';
    /** Apple created an external purchase token for your app, but didn’t receive a report */
    case ExternalPurchaseToken = 'EXTERNAL_PURCHASE_TOKEN';
    /** Customer fails to renew a subscription at the end of the grace period after a failed payment */
    case GracePeriodExpired = 'GRACE_PERIOD_EXPIRED';
    /** Customer redeems a promotional offer, or offer code */
    case OfferRedeemed = 'OFFER_REDEEMED';
    /** (Only in sandbox right now) customer purchased a consumable, non-consumable, or non-renewing subscription */
    case OneTimeCharge = 'ONE_TIME_CHARGE';
    /** Customer is informed of a price change */
    case PriceIncrease = 'PRICE_INCREASE';
    /** The App Store successfully refunded a transaction for an In-App Purchase or Subscription to a customer */
    case Refund = 'REFUND';
    /** The App Store declined a refund for a transaction for an In-App Purchase or Subscription to a customer */
    case RefundDeclined = 'REFUND_DECLINED';
    /** The App Store reversed a previously granted refund due to a dispute that the customer raised */
    case RefundReversed = 'REFUND_REVERSED';
    /** The App Store extended the subscription renewal date for a specific subscription */
    case RenewalExtended = 'RENEWAL_EXTENDED';
    /** The App Store attempting to extend the subscription renewal date that you requested */
    case RenewalExtension = 'RENEWAL_EXTENSION';
    /** A customer, which was previously entitled to an In-App Purchase or Subscription through Family Sharing, no longer has access */
    case Revoke = 'REVOKE';
    /** A customer subscribes to a subscription plan */
    case Subscribed  = 'SUBSCRIBED';
    /** This notification when you ask the App Store to send you a test notification */
    case Test = 'TEST';

    /**
     * @return Subtype[]|null
     */
    public function getAvailableSubtypes(): ?array
    {
        return match ($this) {
            self::DidChangeRenewalPref, self::OfferRedeemed => [
                NotificationSubType::Downgrade,
                NotificationSubType::Upgrade,
            ],
            self::DidChangeRenewalStatus => [
                NotificationSubType::AutoRenewEnabled,
                NotificationSubType::AutoRenewDisabled,
            ],
            self::DidFailToRenew => [
                NotificationSubType::GracePeriod,
            ],
            self::DidRenew => [
                NotificationSubType::BillingRecovery,
            ],
            self::Expired => [
                NotificationSubType::BillingRetry,
                NotificationSubType::PriceIncrease,
                NotificationSubType::ProductNotForSale,
                NotificationSubType::Voluntary,
            ],
            self::ExternalPurchaseToken => [
                NotificationSubType::Unreported,
            ],
            self::PriceIncrease => [
                NotificationSubType::Accepted,
                NotificationSubType::Pending,
            ],
            self::RenewalExtension => [
                NotificationSubType::Failure,
                NotificationSubType::Summary,
            ],
            self::Subscribed => [
                NotificationSubType::InitialBuy,
                NotificationSubType::Resubscribe,
            ],
            default => null,
        };
    }
}
