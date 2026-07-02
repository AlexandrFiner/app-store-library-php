<?php

namespace AppStoreLibrary\Requests;

use JetBrains\PhpStorm\ArrayShape;

/**
 * @link https://developer.apple.com/documentation/retentionmessaging/uploadmessagerequestbody
 */
class UploadRetentionMessageRequestBody
{
    /**
     * @param  RetentionMessageBulletPoint[]|null  $bulletPoints
     * @throws \Exception
     */
    public function __construct(
        private string $header,
        private string $body,
        private ?UploadRetentionMessageImage $image = null,
        private ?array $bulletPoints = null,
        private ?string $headerPosition = null,
    ) {
        if ($this->headerPosition === 'ABOVE_IMAGE' && is_null($this->image)) {
            throw new \Exception('Header position ABOVE_IMAGE requires image');
        }
    }

    #[ArrayShape([
        'header' => 'string',
        'body' => 'string',
        'image' => 'array',
        'bulletPoints' => 'array',
        'headerPosition' => 'string',
    ])]
    public function toResponse(): array
    {
        return array_filter([
            'header' => $this->header,
            'body' => $this->body,
            'image' => $this->image?->toResponse(),
            'bulletPoints' => is_null($this->bulletPoints)
                ? null
                : array_map(
                    fn(RetentionMessageBulletPoint $item) => $item->toResponse(),
                    $this->bulletPoints
                ),
            'headerPosition' => $this->headerPosition,
        ], fn($value) => !is_null($value));
    }
}
