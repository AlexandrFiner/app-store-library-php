<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi;

use AppStoreLibrary\AppStoreObjects\BaseAppStoreObject;
use AppStoreLibrary\AppStoreObjects\Property;
use AppStoreLibrary\Enums\ConnectApi\Report\Period;
use AppStoreLibrary\Enums\ConnectApi\Report\SalesAndTrends\ProductTypeIdentifier;
use Carbon\Carbon;

/**
 * Summary Sales Report shows aggregated sales and download data from the App Store for your apps and in-app purchases.
 * @link https://developer.apple.com/help/app-store-connect/reference/summary-sales-report
 *
 * @property null|string $provider
 * @property null|string $providerCountry
 * @property null|string $SKU
 * @property null|string $developer
 * @property null|string $title
 * @property null|string $version
 * @property null|ProductTypeIdentifier|string $productTypeIdentifier
 * @property null|float $units
 * @property null|float $developerProceeds
 * @property null|int|Carbon $beginDate
 * @property null|int|Carbon $endDate
 * @property null|string $customerCurrency
 * @property null|string $countryCode
 * @property null|string $currencyOfProceeds
 * @property null|int $appleIdentifier
 * @property null|float $customerPrice
 * @property null|string $promoCode
 * @property null|string $parentIdentifier
 * @property null|string $subscription
 * @property null|Period $period
 * @property null|string $category
 * @property null|string $CMB
 * @property null|string $supportedPlatforms
 * @property null|string $device
 * @property null|string $preservedPricing
 * @property null|string $proceedsReason
 * @property null|string $client
 * @property null|string $orderType
 */
class SummarySalesReportRow extends BaseReportRowObject
{
    protected static bool $strict = false;

    public function __construct()
    {
        $this->properties = [
            'Provider' => new Property(type: 'string'),
            'Provider Country' => new Property(type: 'string'),
            'SKU' => new Property(type: 'string'),
            'Developer' => new Property(type: 'string'),
            'Title' => new Property(type: 'string'),
            'Version' => new Property(type: 'string'),
            'Product Type Identifier' => new Property(type: ProductTypeIdentifier::class),
            'Units' => new Property(type: 'float'),
            'Developer Proceeds' => new Property(type: 'float'),
            'Begin Date' => new Property(type: Carbon::class),
            'End Date' => new Property(type: Carbon::class),
            'Customer Currency' => new Property(type: 'string'),
            'Country Code' => new Property(type: 'string'),
            'Currency of Proceeds' => new Property(type: 'string'),
            'Apple Identifier' => new Property(type: 'int'),
            'Customer Price' => new Property(type: 'float'),
            'Promo Code' => new Property(type: 'string'),
            'Parent Identifier' => new Property(type: 'string'),
            'Subscription' => new Property(type: 'string'),
            'Period' => new Property(type: Period::class),
            'Category' => new Property(type: 'string'),
            'CMB' => new Property(type: 'string'),
            'Supported Platforms' => new Property(type: 'string'),
            'Device' => new Property(type: 'string'),
            'Preserved Pricing' => new Property(type: 'string'),
            'Proceeds Reason' => new Property(type: 'string'),
            'Client' => new Property(type: 'string'),
            'Order Type' => new Property(type: 'string'),
        ];
        parent::__construct();
    }
}
