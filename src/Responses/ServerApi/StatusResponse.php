<?php

namespace AppStoreLibrary\Responses\ServerApi;

use AppStoreLibrary\AppStoreObjects\ServerApi\SubscriptionGroupIdentifierItem;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Responses\BaseResponse;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

/**
 * A response that contains status information for all of a customer’s auto-renewable subscriptions in your app.
 * @link https://developer.apple.com/documentation/appstoreserverapi/statusresponse
 */
class StatusResponse extends BaseResponse
{
    /**
     * An array of information for auto-renewable subscriptions, including App Store-signed transaction information
     * and App Store-signed renewal information.
     * @var array[]
     */
    protected Collection $data;
    /** The server environment, sandbox or production, in which the App Store generated the response. */
    protected Environment $environment;
    /** Your app’s App Store identifier. */
    protected int $appAppleId;
    /** Your app’s bundle identifier. */
    protected string $bundleId;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
        $properties = $this->getContent();
        $this->data = collect(
            array_map(fn($item) => SubscriptionGroupIdentifierItem::fromArray($item), $properties['data'])
        );
        $this->environment = Environment::tryFrom($properties['environment']);
        $this->appAppleId = $properties['appAppleId'];
        $this->bundleId = $properties['bundleId'];
    }

    /**
     * @return Collection<SubscriptionGroupIdentifierItem>
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    public function getAppAppleId(): int
    {
        return $this->appAppleId;
    }

    public function getBundleId(): string
    {
        return $this->bundleId;
    }
}
