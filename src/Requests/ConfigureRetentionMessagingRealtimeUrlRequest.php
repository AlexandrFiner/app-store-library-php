<?php

namespace AppStoreLibrary\Requests;

use JetBrains\PhpStorm\ArrayShape;

/**
 * @link https://developer.apple.com/documentation/retentionmessaging/realtimeurlrequest
 */
class ConfigureRetentionMessagingRealtimeUrlRequest
{
    public function __construct(
        private string $realtimeURL,
    ) {}

    #[ArrayShape(['realtimeURL' => 'string'])]
    public function toResponse(): array
    {
        return [
            'realtimeURL' => $this->realtimeURL,
        ];
    }
}
