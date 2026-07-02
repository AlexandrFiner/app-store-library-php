<?php

namespace AppStoreLibrary\Requests;

use JetBrains\PhpStorm\ArrayShape;

/**
 * @link https://developer.apple.com/documentation/retentionmessaging/uploadmessageimage
 */
class UploadRetentionMessageImage
{
    public function __construct(
        private string $imageIdentifier,
        private string $altText,
    ) {}

    #[ArrayShape([
        'imageIdentifier' => 'string',
        'altText' => 'string',
    ])]
    public function toResponse(): array
    {
        return [
            'imageIdentifier' => $this->imageIdentifier,
            'altText' => $this->altText,
        ];
    }
}
