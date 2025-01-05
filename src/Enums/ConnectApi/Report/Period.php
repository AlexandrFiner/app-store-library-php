<?php

namespace AppStoreLibrary\Enums\ConnectApi\Report;

use AppStoreLibrary\Enums\EnumToArray;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscription/attributes
 */
enum Period: string
{
    use EnumToArray;

    case ThreeDays = '3 Days';
    case OneWeek = '7 Days';
    case TwoWeek = '2 Weeks';
    case OneMonth = '1 Month';
    case TwoMonths = '2 Months';
    case ThreeMonths = '3 Months';
    case SixMonths = '6 Months';
    case OneYear = '1 Year';

    public function toIso8601Duration(): string
    {
        return match ($this) {
            self::ThreeDays => 'P3D',
            self::OneWeek => 'P1W',
            self::TwoWeek => 'P2W',
            self::OneMonth => 'P1M',
            self::TwoMonths => 'P2M',
            self::ThreeMonths => 'P3M',
            self::SixMonths => 'P6M',
            self::OneYear => 'P1Y',
        };
    }
}
