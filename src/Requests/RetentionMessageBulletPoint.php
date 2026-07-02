<?php

namespace AppStoreLibrary\Requests;

use JetBrains\PhpStorm\ArrayShape;

/**
 * @link https://developer.apple.com/documentation/retentionmessaging/bulletpoint
 */
class RetentionMessageBulletPoint
{
    public function __construct(
        private string $text,
        private ?string $imageIdentifier = null,
        private ?string $altText = null,
    ) {}

    #[ArrayShape([
        'text' => 'string',
        'imageIdentifier' => 'string',
        'altText' => 'string',
    ])]
    public function toResponse(): array
    {
        return array_filter([
            'text' => $this->text,
            'imageIdentifier' => $this->imageIdentifier,
            'altText' => $this->altText,
        ], fn($value) => !is_null($value));
    }
}
