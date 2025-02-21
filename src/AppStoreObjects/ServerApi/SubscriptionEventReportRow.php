<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi;

use AppStoreLibrary\AppStoreObjects\BaseAppStoreObject;
use AppStoreLibrary\AppStoreObjects\Property;
use AppStoreLibrary\Enums\ConnectApi\Report\Period;
use Carbon\Carbon;

/**
 * The below table shows columns for Subscription Event Report Version 1_3.
 * @link https://developer.apple.com/help/app-store-connect/reference/subscription-event-report
 *
 * @property null|int|Carbon $eventDate
 * @property null|string $event
 * @property null|string $appName
 * @property null|int $appAppleID
 * @property null|string $subscriptionName
 * @property null|int $subscriptionAppleID
 * @property null|int $subscriptionGroupID
 * @property null|Period|string $standardSubscriptionDuration
 * @property null|string $subscriptionOfferType
 * @property null|Period|string $subscriptionOfferDuration
 * @property null|string $marketingOptIn
 * @property null|Period|string $marketingOptInDuration
 * @property null|string $preservedPricing
 * @property null|string $proceedsReason
 * @property null|string $subscriptionOfferName
 * @property null|string $promotionalOfferID
 * @property null|int $consecutivePaidPeriods
 * @property null|int|Carbon $originalStartDate
 * @property null|string $device
 * @property null|string $client
 * @property null|string $state
 * @property null|string $country
 * @property null|string $previousSubscriptionName
 * @property null|string $previousSubscriptionAppleID
 * @property null|int $daysBeforeCanceling
 * @property null|string $cancellationReason
 * @property null|int $daysCanceled
 * @property null|int $quantity
 * @property null|int $paidServiceDaysRecovered
 */
class SubscriptionEventReportRow extends BaseReportRowObject
{
    protected static bool $strict = false;

    public function __construct()
    {
        $this->properties = [
            'Event Date' => new Property(type: Carbon::class),
            'Event' => new Property(type: 'string'),
            'App Name' => new Property(type: 'string'),
            'App Apple ID' => new Property(type: 'int'),
            'Subscription Name' => new Property(type: 'string'),
            'Subscription Apple ID' => new Property(type: 'int'),
            'Subscription Group ID' => new Property(type: 'int'),
            'Standard Subscription Duration' => new Property(type: Period::class),
            'Subscription Offer Type' => new Property(type: 'string'),
            'Subscription Offer Duration' => new Property(type: Period::class),
            'Marketing Opt-In' => new Property(type: 'string'),
            'Marketing Opt-In Duration' => new Property(type: Period::class),
            'Preserved Pricing' => new Property(type: 'string'),
            'Proceeds Reason' => new Property(type: 'string'),
            'Subscription Offer Name' => new Property(type: 'string'),
            'Promotional Offer ID' => new Property(type: 'string'),
            'Consecutive Paid Periods' => new Property(type: 'int'),
            'Original Start Date' => new Property(type: Carbon::class),
            'Device' => new Property(type: 'string'),
            'Client' => new Property(type: 'string'),
            'State' => new Property(type: 'string'),
            'Country' => new Property(type: 'string'),
            'Previous Subscription Name' => new Property(type: 'string'),
            'Previous Subscription Apple ID' => new Property(type: 'string'),
            'Days Before Canceling' => new Property(type: 'int'),
            'Cancellation Reason' => new Property(type: 'string'),
            'Days Canceled' => new Property(type: 'int'),
            'Quantity' => new Property(type: 'int'),
            'Paid Service Days Recovered' => new Property(type: 'int'),
        ];
        parent::__construct();
    }
}
