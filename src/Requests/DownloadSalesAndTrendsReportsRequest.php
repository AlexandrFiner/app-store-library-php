<?php

namespace AppStoreLibrary\Requests;

use AppStoreLibrary\Enums\ConnectApi\Report\SalesAndTrends\Frequency;
use AppStoreLibrary\Enums\ConnectApi\Report\SalesAndTrends\ReportSubType;
use AppStoreLibrary\Enums\ConnectApi\Report\SalesAndTrends\ReportType;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/get-v1-salesreports
 */
class DownloadSalesAndTrendsReportsRequest
{
    /**
     * @throws \Exception
     */
    public function __construct(
        private readonly Frequency $frequency,
        private readonly string $reportDate,
        private readonly ReportSubType $reportSubType,
        private readonly ReportType $reportType,
        private readonly string $vendorNumber,
        private readonly string $version,
    ) {
    }

    #[ArrayShape([
        'frequency' => 'string',
        'reportDate' => 'string',
        'reportSubType' => 'string',
        'reportType' => 'string',
        'vendorNumber' => 'string',
        'version' => 'string',
    ])]
    public function toResponse(): array
    {
        return [
            'frequency' => $this->frequency->value,
            'reportDate' => $this->reportDate,
            'reportSubType' => $this->reportSubType->value,
            'reportType' => $this->reportType->value,
            'vendorNumber' => $this->vendorNumber,
            'version' => $this->version,
        ];
    }
}
