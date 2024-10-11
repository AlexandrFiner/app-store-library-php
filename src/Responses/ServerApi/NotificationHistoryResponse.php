<?php

namespace AppStoreLibrary\Responses\ServerApi;

use AppStoreLibrary\AppStoreObjects\ServerApi\NotificationHistoryResponseItem;
use AppStoreLibrary\Responses\BaseResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * A response that contains the App Store Server Notifications history for your app.
 * @link https://developer.apple.com/documentation/appstoreserverapi/notificationhistoryresponse
 */
class NotificationHistoryResponse extends BaseResponse
{
    protected ?string $paginationToken;
    protected ?bool $hasMore;
    /** @var NotificationHistoryResponseItem[] */
    protected ?array $notificationHistory = null;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
        $properties = $this->getContent();
        $this->paginationToken = $properties['paginationToken'] ?? null;
        $this->hasMore = $properties['hasMore'] ?? null;
        if (isset($properties['notificationHistory'])) {
            foreach ($properties['notificationHistory'] as $notification) {
                $this->notificationHistory[] = NotificationHistoryResponseItem::fromArray($notification);
            }
        }
    }

    /**
     * @return NotificationHistoryResponseItem[]|null
     */
    public function getData(): ?array
    {
        return $this->notificationHistory;
    }

    public function getPaginationToken(): string
    {
        return $this->paginationToken;
    }

    public function hasMore(): bool
    {
        return $this->hasMore;
    }
}
