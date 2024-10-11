<?php

namespace AppStoreLibrary\Enums\ServerApi;

/**
 * A value that indicates your preferred outcome for the refund request.
 * @link https://developer.apple.com/documentation/appstoreserverapi/refundpreference
 */
enum RefundPreference: int
{
    /** The refund preference is undeclared. Use this value to avoid providing information for this field. */
    case Undeclared = 0;
    /** You prefer that Apple grants the refund. */
    case Grants = 1;
    /** You prefer that Apple declines the refund. */
    case Declines = 2;
    /** You have no preference whether Apple grants or declines the refund. */
    case AppleGrants = 3;
}
