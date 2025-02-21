<?php

namespace AppStoreLibrary\Enums\ConnectApi\Report\SalesAndTrends;

use AppStoreLibrary\Enums\EnumToArray;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/get-v1-salesreports
 */
enum ReportSubType: string
{
    use EnumToArray;

    case Summary = 'SUMMARY';
    case Detailed = 'DETAILED';
    case SummaryInstallType = 'SUMMARY_INSTALL_TYPE';
    case SummaryTerritory = 'SUMMARY_TERRITORY';
    case SummaryChannel = 'SUMMARY_CHANNEL';
}