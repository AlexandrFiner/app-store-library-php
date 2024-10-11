<?php

namespace AppStoreLibrary\Responses\ConnectApi;

use App\Helpers\CountryHelper;
use AppStoreLibrary\Responses\BaseResponse;
use AppStoreLibrary\Responses\HasDataTrait;
use AppStoreLibrary\Responses\HasIncludedTrait;
use AppStoreLibrary\Responses\HasPaginationTrait;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

/**
 * @link https://developer.apple.com/documentation/appstoreconnectapi/subscriptionpricesresponse
 */
class SubscriptionPricesResponse extends BaseResponse
{
    use HasDataTrait;
    use HasIncludedTrait;
    use HasPaginationTrait;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
        $this->setData($this->getContent());
        $this->setIncluded($this->getContent());
        $this->setPagination($this->getContent());
    }

    public function getPrices(): array
    {
        $result = collect($this->included)
            ->groupBy('type')
            ->mapWithKeys(function (Collection $items, $key) {
                return [
                    $key => $items->pluck(
                        $key === 'territories' ? 'attributes.currency' : 'attributes.customerPrice',
                        'id',
                    ),
                ];
            });

        return collect($this->data)->mapWithKeys(function ($price) use ($result) {
            $territoryId = $price['relationships']['territory']['data']['id'];
            $pricePointId = $price['relationships']['subscriptionPricePoint']['data']['id'];
            $countryCode = CountryHelper::alpha3ToAlpha2($territoryId);
            return [
                $countryCode => [
                    'currency' => $result['territories'][$territoryId],
                    'price' => (float)$result['subscriptionPricePoints'][$pricePointId],
                    'startDate' => $price['attributes']['startDate'] ?? null,
                ],
            ];
        })->toArray();
    }
}
