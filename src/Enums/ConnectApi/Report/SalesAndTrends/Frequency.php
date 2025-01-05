<?php

namespace AppStoreLibrary\Enums\ConnectApi\Report\SalesAndTrends;

use AppStoreLibrary\Enums\EnumToArray;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/get-v1-salesreports
 */
enum Frequency: string
{
    use EnumToArray;

    case Daily = 'DAILY';
    case Weekly = 'WEEKLY';
    case Monthly = 'MONTHLY';
    case Yearly = 'YEARLY';
}