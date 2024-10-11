<?php

namespace AppStoreLibrary\Enums\ServerApi;

/**
 * A value that indicates the extent to which the customer consumed the in-app purchase.
 * @link https://developer.apple.com/documentation/appstoreserverapi/consumptionstatus
 */
enum ConsumptionStatus: int
{
    /** The consumption status is undeclared. Use this value to avoid providing information for this field. */
    case Undeclared = 0;
    /** The in-app purchase is not consumed. */
    case NotConsumed = 1;
    /** The in-app purchase is partially consumed. */
    case PartiallyConsumed = 2;
    /** The in-app purchase is fully consumed. */
    case FullyConsumed = 3;
}
