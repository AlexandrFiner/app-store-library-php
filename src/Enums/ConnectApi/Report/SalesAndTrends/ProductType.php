<?php

namespace AppStoreLibrary\Enums\ConnectApi\Report\SalesAndTrends;

/**
 * These are the different product type identifiers used in your sales and financial reports for the App Store:
 * @link https://developer.apple.com/help/app-store-connect/reference/product-type-identifiers
 */
enum ProductType: string
{
    case FreeOrPaidApp = 'Free or paid app';
    case AppBundle = 'App Bundle';
    case PaidApp = 'Paid app';
    case ReDownload = 'Re-download';
    case Update = 'Update';
    case InAppPurchase = 'In-App Purchase';
    case RestoredInAppPurchase = 'Restored In-App Purchase';
}
