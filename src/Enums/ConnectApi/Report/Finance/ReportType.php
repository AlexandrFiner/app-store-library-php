<?php

namespace AppStoreLibrary\Enums\ConnectApi\Report\Finance;

use AppStoreLibrary\Enums\EnumToArray;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/get-v1-financereports
 */
enum ReportType: string
{
    use EnumToArray;

    case Financial = 'FINANCIAL';
    case FinanceDetail = 'FINANCE_DETAIL';
}
