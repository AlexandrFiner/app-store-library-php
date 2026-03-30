<?php

namespace AppStoreLibrary\Enums\ServerApi;

/**
 * A length of time that can be assigned to a subscription.
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionofferduration
 */
enum SubscriptionOfferDuration: string
{
    case ThreeDays = 'THREE_DAYS';
    case OneWeek = 'ONE_WEEK';
    case TwoWeeks = 'TWO_WEEKS';
    case OneMonth = 'ONE_MONTH';
    case TwoMonths = 'TWO_MONTHS';
    case ThreeMonths = 'THREE_MONTHS';
    case SixMonths = 'SIX_MONTHS';
    case OneYear = 'ONE_YEAR';

    public function toIso8601Duration(): string
    {
        return match ($this) {
            self::ThreeDays => 'P3D',
            self::OneWeek => 'P1W',
            self::TwoWeeks => 'P2W',
            self::OneMonth => 'P1M',
            self::TwoMonths => 'P2M',
            self::ThreeMonths => 'P3M',
            self::SixMonths => 'P6M',
            self::OneYear => 'P1Y',
        };
    }
}
