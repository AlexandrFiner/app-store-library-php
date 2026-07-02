<?php

namespace AppStoreLibrary\Responses\ServerApi;

use AppStoreLibrary\Responses\BaseResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * @link https://developer.apple.com/documentation/retentionmessaging/defaultconfigurationresponse
 */
class DefaultRetentionMessageConfigurationResponse extends BaseResponse
{
    protected ?string $messageIdentifier = null;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
        $this->messageIdentifier = $this->getContent()['messageIdentifier'] ?? null;
    }

    public function getMessageIdentifier(): ?string
    {
        return $this->messageIdentifier;
    }
}
