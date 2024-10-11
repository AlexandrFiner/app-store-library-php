<?php

namespace AppStoreLibrary\Enums\ConnectApi\Subscription\Attributes;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscription/attributes
 */
enum Period: string
{
    case OneWeek = 'ONE_WEEK';
    case OneMonth = 'ONE_MONTH';
    case TwoMonths = 'TWO_MONTHS';
    case ThreeMonths = 'THREE_MONTHS';
    case SixMonths = 'SIX_MONTHS';
    case OneYear = 'ONE_YEAR';

    public function toIso8601Duration(): string
    {
        return match ($this) {
            self::OneWeek => 'P1W',
            self::OneMonth => 'P1M',
            self::TwoMonths => 'P2M',
            self::ThreeMonths => 'P3M',
            self::SixMonths => 'P6M',
            self::OneYear => 'P1Y',
        };
    }
}
