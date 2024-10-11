<?php

namespace AppStoreLibrary\Enums\ServerNotifications;

/**
 * The customer-provided reason for a refund request.
 * @link https://developer.apple.com/documentation/appstoreservernotifications/consumptionrequestreason
 */
enum ConsumptionRequestReason: string
{
    /** The customer didn’t intend to make the in-app purchase. */
    case UnintendedPurchase = 'UNINTENDED_PURCHASE';
    /** The customer had issues with receiving or using the in-app purchase. */
    case FulfillmentIssue = 'FULFILLMENT_ISSUE';
    /** The customer wasn’t satisfied with the in-app purchase. */
    case UnsatisfiedWithPurchase = 'UNSATISFIED_WITH_PURCHASE';
    /** The customer requested a refund based on a legal reason. */
    case Legal = 'LEGAL';
    /** The customer requested a refund for other reasons. */
    case Other = 'OTHER';
}
