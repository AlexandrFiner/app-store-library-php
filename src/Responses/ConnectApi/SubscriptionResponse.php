<?php

namespace AppStoreLibrary\Responses\ConnectApi;

use AppStoreLibrary\Responses\BaseResponse;
use AppStoreLibrary\Responses\HasDataTrait;
use Psr\Http\Message\ResponseInterface;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionresponse
 */
class SubscriptionResponse extends BaseResponse
{
    use HasDataTrait;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
        $this->setData($this->getContent());
    }
}
