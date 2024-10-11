<?php

namespace AppStoreLibrary\Requests;

use AppStoreLibrary\Enums\ServerNotifications\Subtype;
use AppStoreLibrary\Enums\ServerNotifications\NotificationType;
use Carbon\Carbon;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @link https://developer.apple.cDIom/documentation/appstoreserverapi/notificationhistoryrequest
 */
class NotificationHistoryRequest
{
    public function __construct(
        private int $startDate,
        private int $endDate,
        private ?NotificationType $notificationType = null,
        private ?Subtype $notificationSubtype = null,
        private ?bool $onlyFailures = null,
        private ?string $transactionId = null,
    ) {
        if (Carbon::createFromTimestampMs($this->startDate)->diffInDays() > 180) {
            throw new \Exception('Notification history is available for the past 180 days');
        }
        if (Carbon::createFromTimestampMs($this->endDate)->isBefore(Carbon::createFromTimestampMs($this->startDate))) {
            throw new \Exception('End date can be after start date');
        }
        if ($this->notificationType && $this->transactionId) {
            throw new \Exception('You may include either the transactionId or the notificationType property (or neither) in your query, but not both.');
        }
        if ($this->notificationSubtype && !$this->notificationType) {
            throw new \Exception('If you specify a notificationSubtype, you need to also specify its related notificationType');
        }
    }

    #[ArrayShape([
        'startDate' => 'int',
        'endDate' => 'int',
        'notificationType' => 'string',
        'notificationSubtype' => 'string',
        'onlyFailures' => 'bool',
        'transactionId' => 'string'
    ])]
    public function toResponse(): array
    {
        return array_filter([
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'notificationType' => $this->notificationType?->value,
            'notificationSubtype' => $this->notificationSubtype?->value,
            'onlyFailures' => $this->onlyFailures,
            'transactionId' => $this->transactionId,
        ], fn($value) => !is_null($value));
    }
}
