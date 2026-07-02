<?php

namespace AppStoreLibrary\Requests;

use JetBrains\PhpStorm\ArrayShape;

/**
 * @link https://developer.apple.com/documentation/retentionmessaging/defaultconfigurationrequest
 */
class ConfigureDefaultRetentionMessageRequest
{
    public function __construct(
        private ?string $messageIdentifier = null,
    ) {}

    #[ArrayShape(['messageIdentifier' => 'string'])]
    public function toResponse(): array
    {
        return array_filter([
            'messageIdentifier' => $this->messageIdentifier,
        ], fn($value) => !is_null($value));
    }
}
