<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi;

use AppStoreLibrary\AppStoreObjects\Property;
use AppStoreLibrary\Enums\ConnectApi\Report\Period;

/**
 * Subscription Report
 * The below table shows columns for Subscription Report Version 1_3.
 * @link https://developer.apple.com/help/app-store-connect/reference/subscription-report
 *
 * @property null|string $appName
 * @property null|int $appAppleID
 * @property null|string $subscriptionName
 * @property null|int $subscriptionAppleID
 * @property null|int $subscriptionGroupID
 * @property null|Period|string $standardSubscriptionDuration
 * @property null|string $subscriptionOfferName
 * @property null|string $promotionalOfferID
 * @property null|float $customerPrice
 * @property null|string $customerCurrency
 * @property null|float $developerProceeds
 * @property null|string $proceedsCurrency
 * @property null|string $preservedPricing
 * @property null|string $proceedsReason
 * @property null|string $client
 * @property null|string $device
 * @property null|string $state
 * @property null|string $country
 * @property null|int $activeStandardPriceSubscriptions
 * @property null|int $activeFreeTrialIntroductoryOfferSubscriptions
 * @property null|int $activePayUpFrontIntroductoryOfferSubscriptions
 * @property null|int $activePayAsYouGoIntroductoryOfferSubscriptions
 * @property null|int $freeTrialPromotionalOfferSubscriptions
 * @property null|int $payUpFrontPromotionalOfferSubscriptions
 * @property null|int $payAsYouGoPromotionalOfferSubscriptions
 * @property null|int $freeTrialOfferCodeSubscriptions
 * @property null|int $payUpFrontOfferCodeSubscriptions
 * @property null|int $payAsYouGoOfferCodeSubscriptions
 * @property null|int $marketingOptIns
 * @property null|int $billingRetry
 * @property null|int $gracePeriod
 * @property null|int $subscribers
 * @property null|int $freeTrialWinBackOffers
 * @property null|int $payUpFrontWinBackOffers
 * @property null|int $payAsYouGoWinBackOffers
 */
class SubscriptionReportRow extends BaseReportRowObject
{
    protected static bool $strict = false;

    public function __construct()
    {
        $this->properties = [
            'App Name' => new Property(type: 'string'),
            'App Apple ID' => new Property(type: 'int'),
            'Subscription Name' => new Property(type: 'string'),
            'Subscription Apple ID' => new Property(type: 'int'),
            'Subscription Group ID' => new Property(type: 'int'),
            'Standard Subscription Duration' => new Property(type: Period::class),
            'Subscription Offer Name' => new Property(type: 'string'),
            'Promotional Offer ID' => new Property(type: 'string'),
            'Customer Price' => new Property(type: 'float'),
            'Customer Currency' => new Property(type: 'string'),
            'Developer Proceeds' => new Property(type: 'float'),
            'Proceeds Currency' => new Property(type: 'string'),
            'Preserved Pricing' => new Property(type: 'string'),
            'Proceeds Reason' => new Property(type: 'string'),
            'Client' => new Property(type: 'string'),
            'Device' => new Property(type: 'string'),
            'State' => new Property(type: 'string'),
            'Country' => new Property(type: 'string'),
            'Active Standard Price Subscriptions' => new Property(type: 'int'),
            'Active Free Trial Introductory Offer Subscriptions' => new Property(type: 'int'),
            'Active Pay Up Front Introductory Offer Subscriptions' => new Property(type: 'int'),
            'Active Pay as You Go Introductory Offer Subscriptions' => new Property(type: 'int'),
            'Free Trial Promotional Offer Subscriptions' => new Property(type: 'int'),
            'Pay Up Front Promotional Offer Subscriptions' => new Property(type: 'int'),
            'Pay As You Go Promotional Offer Subscriptions' => new Property(type: 'int'),
            'Free Trial Offer Code Subscriptions' => new Property(type: 'int'),
            'Pay Up Front Offer Code Subscriptions' => new Property(type: 'int'),
            'Pay As You Go Offer Code Subscriptions' => new Property(type: 'int'),
            'Marketing Opt-Ins' => new Property(type: 'int'),
            'Billing Retry' => new Property(type: 'int'),
            'Grace Period' => new Property(type: 'int'),
            'Subscribers' => new Property(type: 'int'),
            'Free Trial Win-back Offers' => new Property(type: 'int'),
            'Pay Up Front Win-back Offers' => new Property(type: 'int'),
            'Pay As You Go Win-back Offers' => new Property(type: 'int'),
        ];
        parent::__construct();
    }
}
