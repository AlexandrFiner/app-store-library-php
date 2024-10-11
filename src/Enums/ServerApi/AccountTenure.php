<?php

namespace AppStoreLibrary\Enums\ServerApi;

/**
 * The age of the customer’s account.
 * @link https://developer.apple.com/documentation/appstoreserverapi/accounttenure
 */
enum AccountTenure: int
{
    /** Account age is undeclared. Use this value to avoid providing information for this field. */
    case Undeclared = 0;
    /** Account age is between 0–3 days. */
    case UptoThreeDays = 1;
    /** Account age is between 3–10 days. */
    case UptoTenDays = 2;
    /** Account age is between 10–30 days. */
    case UptoMouth = 3;
    /** Account age is between 30–90 days. */
    case UptoThreeMouth = 4;
    /** Account age is between 90–180 days. */
    case UptoSixMouth = 5;
    /** Account age is between 180–365 days. */
    case UptoYear = 6;
    /** Account age is over 365 days. */
    case MoreThenYear = 7;
}
