<?php

namespace AppStoreLibrary\Requests;

use JetBrains\PhpStorm\ArrayShape;

/**
 * @link https://developer.apple.com/documentation/retentionmessaging/performancetestrequest
 */
class RetentionMessagingPerformanceTestRequest
{
    public function __construct(
        private string $originalTransactionId,
    ) {}

    #[ArrayShape(['originalTransactionId' => 'string'])]
    public function toResponse(): array
    {
        return [
            'originalTransactionId' => $this->originalTransactionId,
        ];
    }
}
