<?php

namespace AppStoreLibrary\Requests;

use AppStoreLibrary\Enums\ServerApi\AccountTenure;
use AppStoreLibrary\Enums\ServerApi\DeliveryStatus;
use AppStoreLibrary\Enums\ServerApi\LifetimeDollarsPurchased;
use AppStoreLibrary\Enums\ServerApi\LifetimeDollarsRefunded;
use AppStoreLibrary\Enums\ServerApi\Platform;
use AppStoreLibrary\Enums\ServerApi\PlayTime;
use AppStoreLibrary\Enums\ServerApi\RefundPreference;
use AppStoreLibrary\Enums\ServerApi\ConsumptionStatus;
use AppStoreLibrary\Enums\ServerApi\UserStatus;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @link https://developer.apple.com/documentation/appstoreserverapi/send_consumption_information
 */
class ConsumptionRequest
{
    /**
     * @throws \Exception
     */
    public function __construct(
        private AccountTenure $accountTenure,
        private string $appAccountToken,
        private bool $customerConsented,
        private ConsumptionStatus $consumptionStatus,
        private DeliveryStatus $deliveryStatus,
        private LifetimeDollarsPurchased $lifetimeDollarsPurchased,
        private LifetimeDollarsRefunded $lifetimeDollarsRefunded,
        private Platform $platform,
        private PlayTime $playTime,
        private RefundPreference $refundPreference,
        private bool $sampleContentProvided,
        private UserStatus $userStatus,
    ) {
        if (!$this->customerConsented) {
            // The App Store server rejects requests that have a customerConsented value
            // other than true by returning an HTTP 400 error with an InvalidCustomerConsentError
            throw new \Exception("Customer consented must be true");
        }
    }

    #[ArrayShape([
        'accountTenure' => 'int',
        'appAccountToken' => 'string',
        'customerConsented' => 'bool',
        'consumptionStatus' => 'int',
        'deliveryStatus' => 'int',
        'lifetimeDollarsPurchased' => 'int',
        'lifetimeDollarsRefunded' => 'int',
        'platform' => 'int',
        'playTime' => 'int',
        'refundPreference' => 'int',
        'sampleContentProvided' => 'bool',
        'userStatus' => 'int',
    ])]
    public function toResponse(): array
    {
        return [
            'accountTenure' => $this->accountTenure->value,
            'appAccountToken' => $this->appAccountToken,
            'customerConsented' => $this->customerConsented,
            'consumptionStatus' => $this->consumptionStatus->value,
            'deliveryStatus' => $this->deliveryStatus->value,
            'lifetimeDollarsPurchased' => $this->lifetimeDollarsPurchased->value,
            'lifetimeDollarsRefunded' => $this->lifetimeDollarsRefunded->value,
            'platform' => $this->platform->value,
            'playTime' => $this->playTime->value,
            'refundPreference' => $this->refundPreference->value,
            'sampleContentProvided' => $this->sampleContentProvided,
            'userStatus' => $this->userStatus->value,
        ];
    }
}
