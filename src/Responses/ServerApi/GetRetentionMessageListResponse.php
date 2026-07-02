<?php

namespace AppStoreLibrary\Responses\ServerApi;

use AppStoreLibrary\Responses\BaseResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * @link https://developer.apple.com/documentation/retentionmessaging/getmessagelistresponse
 */
class GetRetentionMessageListResponse extends BaseResponse
{
    /** @var array[] */
    protected array $messages;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
        $properties = $this->getContent();
        $this->messages = $properties['messageIdentifiers'] ?? [];
    }

    /**
     * @return array[]
     */
    public function getData(): array
    {
        return $this->messages;
    }
}
