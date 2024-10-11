<?php

namespace AppStoreLibrary\Responses\ServerApi;

use AppStoreLibrary\AppStoreObjects\ServerNotifications\JWSTransactionDecodedPayload;
use AppStoreLibrary\Responses\BaseResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * A response that contains signed transaction information for a single transaction.
 * @link https://developer.apple.com/documentation/appstoreserverapi/transactioninforesponse
 */
class TransactionInfoResponse extends BaseResponse
{
    protected ?JWSTransactionDecodedPayload $transactionInfo = null;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
        $properties = $this->getContent();
        if (isset($properties['signedTransactionInfo'])) {
            $this->transactionInfo = JWSTransactionDecodedPayload::fromJWS($properties['signedTransactionInfo']);
            unset($properties['signedTransactionInfo']);
        }
    }

    public function getData(): ?JWSTransactionDecodedPayload
    {
        return $this->transactionInfo;
    }
}
