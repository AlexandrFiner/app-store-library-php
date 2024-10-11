<?php

namespace AppStoreLibrary\Enums\ServerApi;

/**
 * A value that indicates the dollar amount of in-app purchases the customer has made in your app,
 * since purchasing the app, across all platforms.
 * @link https://developer.apple.com/documentation/appstoreserverapi/lifetimedollarspurchased
 */
enum LifetimeDollarsPurchased: int
{
    /** Lifetime purchase amount is undeclared. Use this value to avoid providing information for this field. */
    case Undeclared = 0;
    /** Lifetime purchase amount is 0 USD. */
    case Zero = 1;
    /** Lifetime purchase amount is between 0.01–49.99 USD. */
    case UptoFifty = 2;
    /** Lifetime purchase amount is between 50–99.99 USD. */
    case UptoOneHundred = 3;
    /** Lifetime purchase amount is between 100–499.99 USD. */
    case UptoFiveHundred = 4;
    /** Lifetime purchase amount is between 500–999.99 USD. */
    case UptoThousand = 5;
    /** Lifetime purchase amount is between 1000–1999.99 USD. */
    case UptoTwoThousand = 6;
    /** Lifetime purchase amount is over 2000 USD. */
    case MoreTwoThousand = 7;
}
