<?php

namespace AppStoreLibrary\Responses\ConnectApi;

use AppStoreLibrary\Responses\BaseResponse;
use AppStoreLibrary\Responses\HasDataTrait;
use AppStoreLibrary\Responses\HasPaginationTrait;
use Psr\Http\Message\ResponseInterface;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionsresponse
 */
class SubscriptionsByGroupResponse extends BaseResponse
{
    use HasDataTrait;
    use HasPaginationTrait;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
        $this->setData($this->getContent());
    }
}
