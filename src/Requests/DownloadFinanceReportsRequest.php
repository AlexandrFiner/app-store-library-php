<?php

namespace AppStoreLibrary\Requests;

use AppStoreLibrary\Enums\ConnectApi\Report\Finance\ReportType;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/get-v1-financereports
 */
class DownloadFinanceReportsRequest
{
    /**
     * @throws \Exception
     */
    public function __construct(
        private readonly string $regionCode,
        private readonly string $reportDate,
        private readonly ReportType $reportType,
        private readonly string $vendorNumber,
    ) {
    }

    #[ArrayShape([
        'regionCode' => 'string',
        'reportDate' => 'string',
        'reportType' => 'string',
        'vendorNumber' => 'string',
    ])]
    public function toResponse(): array
    {
        return [
            'regionCode' => $this->regionCode,
            'reportDate' => $this->reportDate,
            'reportType' => $this->reportType->value,
            'vendorNumber' => $this->vendorNumber,
        ];
    }
}
