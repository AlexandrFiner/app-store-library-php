<?php

namespace AppStoreLibrary\Responses\ServerApi;

use AppStoreLibrary\Responses\BaseResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * @link https://developer.apple.com/documentation/retentionmessaging/performancetestresponse
 */
class RetentionMessagingPerformanceTestResponse extends BaseResponse
{
    protected ?string $requestId = null;
    protected array $config = [];

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
        $properties = $this->getContent();
        $this->requestId = $properties['requestId'] ?? null;
        $this->config = $properties['config'] ?? [];
    }

    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfig(): array
    {
        return $this->config;
    }
}
