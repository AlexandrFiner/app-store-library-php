<?php

namespace AppStoreLibrary\Responses\ServerApi;

use AppStoreLibrary\Responses\BaseResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * @link https://developer.apple.com/documentation/retentionmessaging/realtimeurlresponse
 */
class RetentionMessagingRealtimeUrlResponse extends BaseResponse
{
    protected ?string $realtimeURL = null;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
        $this->realtimeURL = $this->getContent()['realtimeURL'] ?? null;
    }

    public function getRealtimeUrl(): ?string
    {
        return $this->realtimeURL;
    }
}
