<?php

namespace AppStoreLibrary\Responses\ServerApi\RetentionMessaging;

use AppStoreLibrary\Responses\IncomingJsonResponse;

class RealtimeResponse extends IncomingJsonResponse
{

    public function __construct(
        /** @var string UUID */
        protected string $messageIdentifier,
        /** @var ?string The product identifier of the subscription the retention message suggests for your customer to switch to. */
        protected ?string $productId = null,
    ) {
    }

    public function getData(): array
    {
        if ($this->productId) {
            return [
                'alternateProduct' => [
                    'messageIdentifier' => $this->messageIdentifier,
                    'productId' => $this->productId,
                ],
            ];
        }
        return [
            'message' => [
                'messageIdentifier' => $this->messageIdentifier,
            ],
        ];
    }
}