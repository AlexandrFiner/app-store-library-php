<?php

namespace AppStoreLibrary\Enums\ServerApi;

/**
 * A value that indicates whether the app successfully delivered an in-app purchase that works properly.
 * @link https://developer.apple.com/documentation/appstoreserverapi/deliverystatus
 */
enum DeliveryStatus: int
{
    /** The app delivered the consumable in-app purchase and it’s working properly. */
    case Delivered = 0;
    /** The app didn’t deliver the consumable in-app purchase due to a quality issue. */
    case DontDelivered = 1;
    /** The app delivered the wrong item. */
    case WrongItem = 2;
    /** The app didn’t deliver the consumable in-app purchase due to a server outage. */
    case ServerOutage = 3;
    /** The app didn’t deliver the consumable in-app purchase due to an in-game currency change. */
    case CurrencyChange = 4;
    /** The app didn’t deliver the consumable in-app purchase for other reasons. */
    case OtherReasons = 5;
}
